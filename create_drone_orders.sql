-- Create database if it does not exist
CREATE DATABASE IF NOT EXISTS drone_orders_db;

-- Use the created database
USE drone_orders_db;

-- Drop the table if it already exists
DROP TABLE IF EXISTS DroneOrders;

-- Create the DroneOrders table
CREATE TABLE DroneOrders (
    Id INT AUTO_INCREMENT PRIMARY KEY,       -- Unique identifier for each order
    CustomerName TEXT NOT NULL,              -- Customer name
    DroneNo INT NOT NULL,                    -- Drone number
    Destination TEXT NOT NULL,               -- Destination for the order
    OrderFailure INT DEFAULT 0               -- Count of order failures (default to 0)
);

-- Example insert statements (optional)
INSERT INTO DroneOrders (CustomerName, DroneNo, Destination, OrderFailure) VALUES 
('John Doe', 1, '123 Main St', 0),
('Jane Smith', 2, '456 Elm St', 1),
('Alice Johnson', 3, '789 Maple St', 0);
