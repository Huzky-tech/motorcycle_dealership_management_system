CREATE TABLE motorcycles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    model VARCHAR(255) NOT NULL,
    srp DECIMAL(10,2) NOT NULL,
    downpayment DECIMAL(10,2) NOT NULL,
    monthly DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL CHECK (stock >= 0),  -- Added CHECK constraint to ensure stock is non-negative
    image VARCHAR(255) NOT NULL
);

CREATE TABLE inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    model VARCHAR(50) NOT NULL,
    color VARCHAR(50) NOT NULL,
    inquiry_details TEXT NOT NULL,
    purchase_date DATE NOT NULL,
    address VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    mobile VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    motorcycle_id INT, 
    FOREIGN KEY (motorcycle_id) REFERENCES motorcycles(id) ON DELETE CASCADE  -- Set to CASCADE for consistency
);

CREATE TABLE purchase_reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    inquiry_id INT NOT NULL, 
    motorcycle_id INT NOT NULL, 
    customer_name VARCHAR(255) NOT NULL,
    purchase_date DATE NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (inquiry_id) REFERENCES inquiries(id) ON DELETE CASCADE,
    FOREIGN KEY (motorcycle_id) REFERENCES motorcycles(id) ON DELETE CASCADE
);
CREATE TABLE users_new (
    user_id INT PRIMARY KEY,
    username VARCHAR(255),
    email VARCHAR(255) NOT NULL,
    account_id INT
);

CREATE TABLE purchased_report (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    model VARCHAR(255) NOT NULL,
    inquiry_details TEXT NOT NULL,
    purchase_date DATE NOT NULL,
    status VARCHAR(50) NOT NULL
);

