<?php
// setup.php - Database Initializer & Seed Data Script
require_once __DIR__ . '/config/db.php';

echo "<h2>PHBN Traders - Database Setup & Initializer</h2>";

try {
    $pdo = getDBConnection();

    // Create Categories Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS categories (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(100) NOT NULL,
        slug VARCHAR(100) NOT NULL UNIQUE,
        description TEXT,
        image VARCHAR(255),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✓ Categories table ready.<br>";

    // Create Products Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        category_id INTEGER,
        name VARCHAR(150) NOT NULL,
        slug VARCHAR(150) NOT NULL UNIQUE,
        price DECIMAL(10,2) NOT NULL,
        weight_options VARCHAR(255) DEFAULT '100g, 250g, 500g, 1kg, 5kg Bulk',
        description TEXT,
        origin VARCHAR(100),
        benefits TEXT,
        heat_level VARCHAR(50) DEFAULT 'Mild',
        image VARCHAR(255),
        stock INTEGER DEFAULT 100,
        is_featured INTEGER DEFAULT 0,
        status VARCHAR(20) DEFAULT 'active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
    )");
    echo "✓ Products table ready.<br>";

    // Create Orders Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        order_number VARCHAR(50) UNIQUE NOT NULL,
        customer_name VARCHAR(100) NOT NULL,
        customer_email VARCHAR(100) NOT NULL,
        customer_phone VARCHAR(20) NOT NULL,
        shipping_address TEXT NOT NULL,
        city VARCHAR(100) NOT NULL,
        postal_code VARCHAR(20) NOT NULL,
        payment_method VARCHAR(50) DEFAULT 'cod',
        total_amount DECIMAL(10,2) NOT NULL,
        status VARCHAR(30) DEFAULT 'Pending',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✓ Orders table ready.<br>";

    // Create Order Items Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS order_items (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        order_id INTEGER NOT NULL,
        product_id INTEGER,
        product_name VARCHAR(150) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        quantity INTEGER NOT NULL,
        weight VARCHAR(50),
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
    )");
    echo "✓ Order Items table ready.<br>";

    // Create Wholesale Inquiries Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS inquiries (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        company VARCHAR(150),
        quantity_needed VARCHAR(100),
        message TEXT NOT NULL,
        status VARCHAR(30) DEFAULT 'New',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✓ Wholesale Inquiries table ready.<br>";

    // Create Admins Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS admins (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username VARCHAR(50) UNIQUE NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        email VARCHAR(100) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✓ Admins table ready.<br>";

    // Seed Categories
    $categories = [
        ['Ground Spices', 'ground-spices', 'Finely ground, aromatic single-spice powders processed at low temperatures to preserve natural essential oils.', 'assets/images/ground-spices.svg'],
        ['Whole Spices', 'whole-spices', 'Hand-picked whole spices direct from traditional spice estates with rich natural aroma and authentic oils.', 'assets/images/whole-spices.svg'],
        ['Blended Masalas', 'blended-masalas', 'Masterfully crafted spice blends combining age-old heritage recipes for curry, biryani, and roasted delights.', 'assets/images/blended-masalas.svg'],
        ['Exotic & Premium', 'exotic-premium', 'Rare, luxury spice varieties including Grade-1 Kashmiri Saffron, Ceylon Cinnamon, and Green Cardamom.', 'assets/images/exotic-premium.svg'],
        ['Organic & Wellness', 'organic-wellness', 'Certified organic spices rich in antioxidants, immunity-boosting bioactives, and herbal wellness properties.', 'assets/images/organic-wellness.svg']
    ];

    $stmt = $pdo->query("SELECT COUNT(*) FROM categories");
    if ($stmt->fetchColumn() == 0) {
        $insertCat = $pdo->prepare("INSERT INTO categories (name, slug, description, image) VALUES (?, ?, ?, ?)");
        foreach ($categories as $cat) {
            $insertCat->execute($cat);
        }
        echo "✓ Seeded 5 Spice Categories.<br>";
    } else {
        // Update existing categories to use clean SVG images
        $updateCat = $pdo->prepare("UPDATE categories SET image = ? WHERE slug = ?");
        foreach ($categories as $cat) {
            $updateCat->execute([$cat[3], $cat[1]]);
        }
        echo "✓ Updated existing categories with authentic spice visuals.<br>";
    }

    // Seed Admin User
    $stmt = $pdo->query("SELECT COUNT(*) FROM admins");
    if ($stmt->fetchColumn() == 0) {
        $adminPass = password_hash('admin123', PASSWORD_DEFAULT);
        $insertAdmin = $pdo->prepare("INSERT INTO admins (username, password_hash, email) VALUES (?, ?, ?)");
        $insertAdmin->execute(['admin', $adminPass, 'admin@phbntraders.com']);
        echo "✓ Seeded default Admin user (Username: <b>admin</b> / Password: <b>admin123</b>).<br>";
    }

    // Seed Products
    $products = [
        [
            1, // Ground Spices
            'Kashmiri Red Chilli Powder (Mild & Vibrant Color)',
            'kashmiri-red-chilli-powder',
            220.00,
            '100g, 250g, 500g, 1kg, 5kg Bulk',
            'Sourced from the sun-drenched valleys of Kashmir. Sun-dried and cold-ground to retain vivid red hue without intense fiery heat. Adds vibrant color and subtle tangy warmth to curries and gravies.',
            'Kashmir Valley, India',
            'Rich in Vitamin C, capsaicin for metabolism, high antioxidant profile.',
            'Mild (Color rich)',
            'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=600&auto=format&fit=crop&q=80',
            120,
            1
        ],
        [
            1, // Ground Spices
            'High-Curcumin Turmeric Powder (Haldi)',
            'high-curcumin-turmeric-powder',
            180.00,
            '100g, 250g, 500g, 1kg, 5kg Bulk',
            'Pure Lakadong & Salem turmeric roots with >5.2% natural curcumin content. Deep earthy golden color with intense earthy aroma.',
            'Meghalaya / Salem, India',
            'Powerful anti-inflammatory, immunity booster, promotes joint and skin health.',
            'None (Earthy)',
            'assets/images/ground-spices.svg',
            150,
            1
        ],
        [
            2, // Whole Spices
            'Royal Malabar Black Pepper Bold (Kali Mirch)',
            'royal-malabar-black-pepper',
            340.00,
            '100g, 250g, 500g, 1kg, 5kg Bulk',
            'Tellicherry Extra Bold Garbled black peppercorns from Malabar coast. Pungent, sharp piperine bite with complex floral notes.',
            'Malabar Coast, Kerala',
            'Enhances nutrient absorption (piperine), aids digestion, antimicrobial.',
            'Medium-Hot',
            'assets/images/whole-spices.svg',
            90,
            1
        ],
        [
            2, // Whole Spices
            'Idukki Green Cardamom Pods 8mm (Choti Elaichi)',
            'idukki-green-cardamom-pods',
            580.00,
            '100g, 250g, 500g, 1kg',
            'Handpicked extra-large 8mm green cardamom pods packed with aromatic black seeds. Intensely sweet eucalyptus-citrus fragrance.',
            'Western Ghats, Idukki, Kerala',
            'Natural mouth freshener, digestive tonic, blood pressure support.',
            'Sweet Aromatic',
            'assets/images/whole-spices.svg',
            65,
            1
        ],
        [
            4, // Exotic & Premium
            'Grade-1 Super Negin Kashmiri Saffron (Kesar)',
            'grade-1-kashmiri-saffron',
            1250.00,
            '1g, 2g, 5g, 10g',
            'Pure authentic all-red crocus filaments from Pampore, Kashmir. Rich in crocin and safranal giving deep amber tint and regal aroma.',
            'Pampore, Jammu & Kashmir',
            'Mood enhancer, glowing skin, antioxidant powerhouse, warm tonic for milk and biryani.',
            'Exotic Aroma',
            'assets/images/exotic-premium.svg',
            40,
            1
        ],
        [
            2, // Whole Spices
            'True Ceylon Cinnamon Bark Sticks (Dalchini)',
            'true-ceylon-cinnamon-bark',
            420.00,
            '100g, 250g, 500g, 1kg',
            'Delicate multi-layered Ceylon cinnamon quills (Cinnamomum verum) low in coumarin. Sweet delicate woody flavor compared to hard Cassia.',
            'Southern Province, Sri Lanka',
            'Supports healthy blood sugar balance, heart health, safe for long term consumption.',
            'Sweet Spicy',
            'assets/images/whole-spices.svg',
            80,
            0
        ],
        [
            3, // Blended Masalas
            'Heritage Shahi Garam Masala Blend',
            'heritage-shahi-garam-masala',
            260.00,
            '100g, 250g, 500g, 1kg',
            'Artisanal blend of 14 whole spices roasted in small batches: mace, nutmeg, star anise, cardamom, cinnamon, clove, and cumin.',
            'PHBN Master Blend Recipe',
            'Stimulates digestive fire (Agni), enhances metabolism, rich aroma finish.',
            'Warm Spiced',
            'assets/images/blended-masalas.svg',
            110,
            1
        ],
        [
            3, // Blended Masalas
            'Hyderabadi Dum Biryani Masala',
            'hyderabadi-dum-biryani-masala',
            280.00,
            '100g, 250g, 500g, 1kg',
            'Authentic Nawabi secret spice formulation with stone flower (Kalpasi), mace, rose petals, and whole black cardamom for rich biryani.',
            'Hyderabad, India',
            'Brings royal catering flavor to home kitchens.',
            'Medium Spiced',
            'assets/images/blended-masalas.svg',
            95,
            0
        ],
        [
            5, // Organic & Wellness
            'Organic Ginger Powder (Saunth)',
            'organic-ginger-powder',
            210.00,
            '100g, 250g, 500g',
            'Certified organic dry ginger powder ground from pesticide-free ginger rhizomes. Zesty, sharp warming punch.',
            'Assam / Wayanad',
            'Relieves nausea, clears throat congestion, soothing tea additive.',
            'Zesty Hot',
            'assets/images/organic-wellness.svg',
            75,
            0
        ],
        [
            2, // Whole Spices
            'Star Anise & Cloves Whole Combo (Chakra Phool & Laung)',
            'star-anise-cloves-combo',
            390.00,
            '100g, 250g, 500g',
            'Eight-pointed whole star anise combined with essential oil-rich Zanzibar cloves. Perfect for broths, mulled beverages, and stews.',
            'Vietnam / Zanzibar',
            'Antiviral shikimic acid in star anise, eugenol rich antiseptic cloves.',
            'Pungent Sweet',
            'assets/images/whole-spices.svg',
            60,
            0
        ]
    ];

    $stmt = $pdo->query("SELECT COUNT(*) FROM products");
    if ($stmt->fetchColumn() == 0) {
        $insertProd = $pdo->prepare("INSERT INTO products 
            (category_id, name, slug, price, weight_options, description, origin, benefits, heat_level, image, stock, is_featured) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        foreach ($products as $prod) {
            $insertProd->execute($prod);
        }
        echo "✓ Seeded 10 Premium Spice Products.<br>";
    } else {
        // Update existing products with authentic images
        $updateProd = $pdo->prepare("UPDATE products SET image = ? WHERE slug = ?");
        foreach ($products as $prod) {
            $updateProd->execute([$prod[9], $prod[2]]);
        }
        echo "✓ Updated existing products with authentic spice visuals.<br>";
    }

    echo "<br><strong style='color:green;'>Setup Completed Successfully!</strong><br>";
    echo "<a href='index.php'>Go to Homepage</a> | <a href='admin/index.php'>Go to Admin Panel</a>";

} catch (PDOException $e) {
    die("<span style='color:red;'>Setup Error: " . $e->getMessage() . "</span>");
}
