CREATE TABLE up_user (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         login VARCHAR(100) NOT NULL UNIQUE,
                         password_hash VARCHAR(255) NOT NULL,
                         date_create DATETIME DEFAULT CURRENT_TIMESTAMP,
                         date_modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
CREATE TABLE up_category (
                             id INT AUTO_INCREMENT PRIMARY KEY,
                             name VARCHAR(255) NOT NULL,
                             slug_code VARCHAR(100) NOT NULL UNIQUE,
                             is_active BOOLEAN DEFAULT TRUE,
                             date_create DATETIME DEFAULT CURRENT_TIMESTAMP,
                             date_modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;
CREATE TABLE up_product (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(255) NOT NULL,
                            description_short TEXT,
                            description_long TEXT,
                            price DECIMAL(10,2) NOT NULL,
                            is_active BOOLEAN DEFAULT TRUE,
                            user_id INT NOT NULL,
                            date_create DATETIME DEFAULT CURRENT_TIMESTAMP,
                            date_modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

                            CONSTRAINT fk_product_user
                                FOREIGN KEY (user_id) REFERENCES up_user(id)
                                    ON DELETE RESTRICT
) ;
CREATE TABLE up_category_product (
                                     category_id INT NOT NULL,
                                     product_id INT NOT NULL,

                                     PRIMARY KEY (category_id, product_id),

                                     CONSTRAINT fk_cp_category
                                         FOREIGN KEY (category_id) REFERENCES up_category(id)
                                             ON DELETE CASCADE,

                                     CONSTRAINT fk_cp_product
                                         FOREIGN KEY (product_id) REFERENCES up_product(id)
                                             ON DELETE CASCADE
) ;
CREATE TABLE up_image (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          product_id INT NOT NULL,
                          path VARCHAR(500) NOT NULL,
                          is_main BOOLEAN DEFAULT FALSE,
                          width INT,
                          height INT,
                          date_create DATETIME DEFAULT CURRENT_TIMESTAMP,

                          CONSTRAINT fk_image_product
                              FOREIGN KEY (product_id) REFERENCES up_product(id)
                                  ON DELETE CASCADE
);
CREATE TABLE up_order (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          product_id INT NOT NULL,
                          status ENUM('pending', 'paid', 'sent', 'completed', 'cancelled')
        NOT NULL DEFAULT 'pending',
                          total_price DECIMAL(10,2) NOT NULL,
                          client_name VARCHAR(255),
                          client_phone VARCHAR(255),
                          client_address VARCHAR(255),
                          client_email VARCHAR(255),
                          date_create DATETIME DEFAULT CURRENT_TIMESTAMP,
                          date_modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

                          CONSTRAINT fk_order_product
                              FOREIGN KEY (product_id) REFERENCES up_product(id)
                                  ON DELETE RESTRICT
);

