# Tính Thể Tích Hình Trụ Bằng Phương Pháp Tích Phân
# Cylinder Volume Calculation Using Integration Method

## 📚 Tổng Quan / Overview

Tài liệu này giải thích cách tính thể tích hình trụ sử dụng phương pháp tích phân (calculus integration) thay vì công thức trực tiếp.

This document explains how to calculate cylinder volume using the integration method (calculus) instead of the direct formula.

## 🎯 Bài Toán / Problem

**Đề bài:** Tính thể tích hình trụ có bán kính r = 2 cm và chiều cao h = 10 cm

**Problem:** Calculate the volume of a cylinder with radius r = 2 cm and height h = 10 cm

## 🧮 Phương Pháp Giải / Solution Methods

### 1️⃣ Phương Pháp Tích Phân Giải Tích (Analytical Integration)

#### Lý Thuyết / Theory

Thể tích của hình trụ có thể được tính bằng cách tích phân diện tích mặt cắt ngang theo chiều cao:

The volume of a cylinder can be calculated by integrating the cross-sectional area along its height:

```
V = ∫₀ʰ A(z) dz
```

Trong đó / Where:
- `A(z)` = diện tích mặt cắt ngang tại vị trí z / cross-sectional area at position z
- `h` = chiều cao hình trụ / height of cylinder
- `z` = biến tích phân (từ 0 đến h) / integration variable (from 0 to h)

#### Các Bước Giải / Steps

**Bước 1:** Thiết lập tích phân

```
V = ∫₀ʰ π×r² dz
```

Với hình trụ, diện tích mặt cắt `A(z) = π×r²` không đổi theo z.

For a cylinder, the cross-sectional area `A(z) = π×r²` is constant with respect to z.

**Bước 2:** Đưa hằng số ra ngoài dấu tích phân

```
V = π×r² ∫₀ʰ dz
```

**Bước 3:** Tính tích phân

```
V = π×r² × [z]₀ʰ
```

Nguyên hàm của 1 theo z là z / The antiderivative of 1 with respect to z is z

**Bước 4:** Áp dụng cận tích phân

```
V = π×r² × (h - 0) = π×r²×h
```

**Bước 5:** Thay số và tính toán

Với r = 2 cm, h = 10 cm:

```
V = π × 2² × 10
V = π × 4 × 10
V = 40π
V ≈ 125.6637 cm³
```

### 2️⃣ Phương Pháp Tích Phân Số (Numerical Integration)

#### Lý Thuyết / Theory

Sử dụng phương pháp tổng Riemann (Riemann Sum) để xấp xỉ tích phân:

Using the Riemann Sum method to approximate the integral:

```
V ≈ Σᵢ₌₁ⁿ A(zᵢ) × Δz
```

Trong đó / Where:
- `n` = số bước chia / number of steps
- `Δz = h/n` = độ dày mỗi lát cắt / thickness of each slice
- `zᵢ` = vị trí tại bước thứ i / position at step i
- `A(zᵢ)` = diện tích mặt cắt tại zᵢ / cross-sectional area at zᵢ

#### Quy Trình / Process

1. **Chia nhỏ hình trụ:** Chia hình trụ thành n lát cắt mỏng, mỗi lát có độ dày Δz = h/n

   **Divide the cylinder:** Split the cylinder into n thin slices, each with thickness Δz = h/n

2. **Tính thể tích từng lát:** Với mỗi lát tại vị trí zᵢ:
   ```
   Vᵢ = A(zᵢ) × Δz = π×r² × Δz
   ```

   **Calculate each slice volume:** For each slice at position zᵢ

3. **Cộng tổng:** Thể tích tổng = tổng thể tích các lát cắt
   ```
   V = Σᵢ₌₁ⁿ Vᵢ
   ```

   **Sum up:** Total volume = sum of all slice volumes

4. **Khi n → ∞:** Kết quả tiến đến giá trị chính xác
   
   **As n → ∞:** The result approaches the exact value

## 💻 Sử Dụng / Usage

### Cài Đặt / Installation

Các file đã được tạo trong project Laravel:

The following files have been created in the Laravel project:

```
api/app/Utils/IntegrationGeometry.php
api/app/Console/Commands/CalculateCylinderVolumeIntegration.php
```

### Chạy Lệnh / Run Command

#### 1. Tính cả hai phương pháp (mặc định)

Calculate both methods (default):

```bash
cd api
php artisan geometry:cylinder-volume-integration
```

#### 2. Chỉ tính phương pháp số

Numerical method only:

```bash
php artisan geometry:cylinder-volume-integration --method=numerical
```

#### 3. Chỉ tính phương pháp giải tích

Analytical method only:

```bash
php artisan geometry:cylinder-volume-integration --method=analytical
```

#### 4. Tùy chỉnh bán kính và chiều cao

Custom radius and height:

```bash
php artisan geometry:cylinder-volume-integration 5 15
```

#### 5. Tùy chỉnh số bước tích phân

Custom number of integration steps:

```bash
php artisan geometry:cylinder-volume-integration 2 10 --steps=10000
```

### Sử Dụng Trong Code / Use in Code

#### Phương pháp số / Numerical method:

```php
use App\Utils\IntegrationGeometry;

$result = IntegrationGeometry::calculateCylinderVolumeByIntegration(
    radius: 2,      // cm
    height: 10,     // cm
    steps: 1000     // số bước tích phân / integration steps
);

echo "Volume: " . $result['volume'] . " cm³";
echo "Formula: " . $result['formula'];
```

#### Phương pháp giải tích / Analytical method:

```php
use App\Utils\IntegrationGeometry;

$result = IntegrationGeometry::calculateCylinderVolumeAnalytical(
    radius: 2,      // cm
    height: 10      // cm
);

echo "Volume: " . $result['volume'] . " cm³";
foreach ($result['integration_steps'] as $step) {
    echo $step['description'] . ": " . $step['formula'] . "\n";
}
```

## 📊 Kết Quả Mẫu / Sample Results

Với r = 2 cm, h = 10 cm:

**Phương pháp giải tích / Analytical:**
```
V = π × r² × h
V = π × 2² × 10
V = 125.6637 cm³
```

**Phương pháp số (1000 bước) / Numerical (1000 steps):**
```
V ≈ 125.6637 cm³
Sai số / Error: ~0.0001 cm³
```

## 🔬 So Sánh / Comparison

| Phương pháp / Method | Ưu điểm / Advantages | Nhược điểm / Disadvantages |
|---------------------|---------------------|---------------------------|
| **Giải tích** | • Kết quả chính xác tuyệt đối<br>• Nhanh<br>• Cho công thức tổng quát | • Cần biết công thức nguyên hàm<br>• Không áp dụng được cho hình phức tạp |
| **Số** | • Áp dụng cho mọi hình dạng<br>• Dễ hiểu, trực quan | • Chỉ xấp xỉ (phụ thuộc số bước)<br>• Tốn thời gian tính toán |

| Method | Advantages | Disadvantages |
|--------|-----------|---------------|
| **Analytical** | • Exact result<br>• Fast<br>• Provides general formula | • Need antiderivative formula<br>• Cannot apply to complex shapes |
| **Numerical** | • Works for any shape<br>• Easy to understand, intuitive | • Only approximate (depends on steps)<br>• Computationally expensive |

## 🎓 Ý Nghĩa Giáo Dục / Educational Significance

Phương pháp tích phân giúp:

The integration method helps:

1. **Hiểu bản chất của công thức V = πr²h**
   
   Understand the nature of formula V = πr²h

2. **Áp dụng cho các hình phức tạp hơn**
   
   Apply to more complex shapes (cones, spheres, irregular solids)

3. **Kết nối toán học với thực tế**
   
   Connect mathematics with reality

4. **Nền tảng cho các bài toán nâng cao**
   
   Foundation for advanced problems (variable cross-sections, optimization)

## 📚 Tài Liệu Tham Khảo / References

- Calculus: Early Transcendentals - James Stewart
- Integration methods in geometry
- Riemann sum approximation techniques

## 👨‍💻 Tác Giả / Author

Generated for Fleetbase project - Integration-based geometric calculations

## 📜 License

AGPL-3.0 (same as Fleetbase project)
