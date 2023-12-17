CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role VARCHAR(20) NOT NULL CHECK (`role` IN ('admin','agent','support'))
);

CREATE TABLE auth_tokens ( 
    token VARCHAR(256) PRIMARY KEY, 
    user_id INT NOT NULL, 
    expiry_date DATE NOT NULL, 
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE 
); 

CREATE TABLE customers (
    customer_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    birth_date DATE NOT NULL,
    address VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE policies (
    policy_id INT PRIMARY KEY AUTO_INCREMENT,
    policy_number VARCHAR(20) UNIQUE NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    insurance_type VARCHAR(50) NOT NULL,
    coverage DECIMAL(10, 2) NOT NULL,
    premium DECIMAL(10, 2) NOT NULL,
    customer_id INT NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
);
CREATE TABLE insurance_products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    type VARCHAR(50) NOT NULL,
    coverage DECIMAL(10, 2) NOT NULL,
    default_sum_insured DECIMAL(10, 2) NOT NULL,
    default_premium DECIMAL(10, 2) NOT NULL,
    customer_id INT NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
);

CREATE TABLE insurance_events (
    event_id INT PRIMARY KEY AUTO_INCREMENT,
    event_date DATE NOT NULL,
    description TEXT,
    policy_id INT NOT NULL,
    FOREIGN KEY (policy_id) REFERENCES policies(policy_id)
);