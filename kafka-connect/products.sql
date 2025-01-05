-- Create the 'products' table
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
);

-- Insert sample data into the 'products' table
INSERT INTO products (product_name, description, price, quantity)
VALUES
    ('Laptop', 'Powerful laptop for work and play', 1299.99, 10),
    ('Smartphone', 'Latest flagship smartphone', 999.99, 20),
    ('Headphones', 'Wireless noise-canceling headphones', 199.99, 50),
    ('Tablet', 'Versatile tablet for entertainment and productivity', 399.99, 30);