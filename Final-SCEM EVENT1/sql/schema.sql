CREATE DATABASE SCEM;

USE SCEM;

-- Users Table
CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('student', 'organizer') DEFAULT 'student'
);

-- Events Table
CREATE TABLE events (
  event_id INT AUTO_INCREMENT PRIMARY KEY,
  event_name VARCHAR(100) NOT NULL,
  event_type ENUM('technical', 'non_technical') NOT NULL,
  event_date DATETIME NOT NULL,
  venue VARCHAR(100) NOT NULL,
  max_capacity INT DEFAULT 120,
  registered INT DEFAULT 0,
  event_status ENUM('upcoming', 'completed', 'cancelled') DEFAULT 'upcoming'
);

-- Event Registrations Table
CREATE TABLE registrations (
  registration_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  event_id INT,
  registration_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (event_id) REFERENCES events(event_id)
);

-- Feedback Table
CREATE TABLE feedback (
  feedback_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  event_id INT,
  feedback_text TEXT,
  submission_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (event_id) REFERENCES events(event_id)
);

-- Archive Table for Completed Events
CREATE TABLE archived_events (
    event_id INT PRIMARY KEY,
    event_name VARCHAR(100),
    event_type ENUM('technical', 'non_technical'),
    event_date DATETIME,
    venue VARCHAR(100),
    max_capacity INT,
    registered INT,
    event_status ENUM('upcoming', 'completed', 'cancelled')
);

DELIMITER $$

-- Trigger for Handling Completed Events
CREATE TRIGGER after_event_completion
AFTER UPDATE ON events
FOR EACH ROW
BEGIN
    IF NEW.event_status = 'completed' THEN
        -- Archive the event before deleting it from the main table
        INSERT INTO archived_events (event_id, event_name, event_type, event_date, venue, max_capacity, registered, event_status)
        VALUES (NEW.event_id, NEW.event_name, NEW.event_type, NEW.event_date, NEW.venue, NEW.max_capacity, NEW.registered, NEW.event_status);
        
        -- Delete the completed event
        DELETE FROM events WHERE event_id = NEW.event_id;
    END IF;
END $$

DELIMITER ;
