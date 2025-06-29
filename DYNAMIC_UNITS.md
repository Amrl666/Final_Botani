# Dynamic Product Units Feature

## Overview

The Dynamic Product Units feature allows products to have flexible units and ordering increments, making the system more suitable for agricultural and retail businesses.

## Features

### 1. Multiple Unit Types
Products can now be sold in various units:
- **kg** (Kilogram) - For bulk items like rice, vegetables by weight
- **gram** (Gram) - For spices and small quantities
- **buah** (Piece/Fruit) - For individual fruits
- **ikat** (Bundle) - For vegetables tied together
- **pack** (Pack) - For packaged items
- **box** (Box) - For bulk items in boxes
- **pcs** (Pieces) - For individual items

### 2. Flexible Ordering Increments
Each product can have a custom minimum increment:
- **0.5 kg** for vegetables that can be sold in half-kilogram increments
- **1 pcs** for individual items
- **0.1 kg** for spices sold in small quantities
- **1 ikat** for bundled vegetables

### 3. Validation Rules
- Orders must be in multiples of the minimum increment
- Cannot order more than available stock
- Real-time validation in cart and order forms

## Database Schema

### New Fields in Products Table
```sql
ALTER TABLE products ADD COLUMN unit VARCHAR(10) DEFAULT 'kg';
ALTER TABLE products ADD COLUMN min_increment DECIMAL(8,2) DEFAULT 0.5;
```

### Field Descriptions
- `unit`: The unit of measurement for the product
- `min_increment`: The minimum quantity that can be ordered

## Implementation Details

### 1. Model Updates
```php
// app/Models/Product.php
protected $fillable = [
    'name', 'description', 'price', 'unit', 'min_increment', 'image', 'stock', 'featured'
];

protected $casts = [
    'featured' => 'boolean',
    'min_increment' => 'decimal:2',
];
```

### 2. Controller Validation
```php
// Product validation rules
'unit' => 'required|string|in:kg,gram,buah,ikat,pack,box,pcs',
'min_increment' => 'required|numeric|min:0.01',

// Cart validation
if ($request->quantity % $product->min_increment != 0) {
    return back()->with('error', "Jumlah harus kelipatan {$product->min_increment} {$product->unit}.");
}
```

### 3. View Updates
All product displays now show the appropriate unit:
- Product listings
- Product details
- Cart items
- Order confirmations
- WhatsApp messages

## Usage Examples

### 1. Creating a Product with Custom Unit
```php
Product::create([
    'name' => 'Tomat Segar',
    'price' => 15000,
    'unit' => 'kg',
    'min_increment' => 0.5,
    'stock' => 50,
    // ... other fields
]);
```

### 2. Creating a Product with Piece Unit
```php
Product::create([
    'name' => 'Jeruk Manis',
    'price' => 5000,
    'unit' => 'buah',
    'min_increment' => 1,
    'stock' => 100,
    // ... other fields
]);
```

### 3. Creating a Product with Bundle Unit
```php
Product::create([
    'name' => 'Kangkung Segar',
    'price' => 3000,
    'unit' => 'ikat',
    'min_increment' => 1,
    'stock' => 25,
    // ... other fields
]);
```

## Frontend Integration

### 1. Product Display
```blade
<span class="product-stock">
    Stok: {{ $product->stock }} {{ $product->unit ?? 'units' }}
</span>
```

### 2. Order Form
```blade
<input type="number"
       name="quantity"
       min="{{ $product->min_increment ?? 1 }}"
       step="{{ $product->min_increment ?? 1 }}"
       value="{{ $product->min_increment ?? 1 }}">
<span>{{ $product->unit ?? 'units' }}</span>
```

### 3. Cart Display
```blade
<p class="text-sm text-gray-500">
    {{ $item->quantity }} {{ $item->product->unit ?? 'units' }}
</p>
```

## WhatsApp Integration

Orders sent via WhatsApp now include the correct unit:
```
Halo Admin, saya ingin memesan *Tomat Segar*:
- Nama: John Doe
- No HP: 08123456789
- Alamat: Jl. Contoh No. 123
- Jumlah: 2.5 kg
- Total: Rp 37,500
```

## Migration and Seeding

### 1. Run Migration
```bash
php artisan migrate
```

### 2. Update Existing Products
```bash
php artisan db:seed --class=UpdateProductsWithUnitsSeeder
```

This will set all existing products to use 'kg' as the default unit with 0.5 as the minimum increment.

## Benefits

1. **Flexibility**: Supports various agricultural product types
2. **User Experience**: Clear unit display throughout the system
3. **Business Logic**: Enforces proper ordering increments
4. **Scalability**: Easy to add new unit types
5. **Consistency**: Uniform unit handling across all features

## Future Enhancements

1. **Unit Conversion**: Automatic conversion between units
2. **Bulk Pricing**: Different prices for different quantities
3. **Seasonal Units**: Units that change based on season
4. **Regional Units**: Support for local measurement units
5. **Unit Categories**: Grouping products by unit type

## Testing

Test cases should cover:
- Product creation with different units
- Order validation with minimum increments
- Cart operations with unit-specific quantities
- WhatsApp message formatting with units
- Admin interface unit management 