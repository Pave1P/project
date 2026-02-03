-- Вставляем пользователей
INSERT INTO up_user (login, password_hash)
VALUES ('admin', '$2y$10$ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmn'),
       ('admin1', '$2y$10$1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkl'),
       ('admin2', '$2y$10$ZYXWVUTSRQPONMLKJIHGFEDCBA9876543210zyxwvutsrqponm');

-- Вставляем категории
INSERT INTO up_category (name, slug_code, is_active)
VALUES ('Мужская одежда', 'mens-clothing', TRUE),
       ('Женская одежда', 'womens-clothing', TRUE),
       ('Детская одежда', 'kids-clothing', TRUE),
       ('Верхняя одежда', 'outerwear', TRUE),
       ('Обувь', 'shoes', TRUE),
       ('Аксессуары', 'accessories', TRUE),
       ('Спортивная одежда', 'sportswear', TRUE);

-- Вставляем товары (ИСПРАВЛЕНА КАВЫЧКА В СТРОКЕ 8)
INSERT INTO up_product (name, description_short, description_long, price, is_active, user_id)
VALUES ('Джинсы синие', 'Классические синие джинсы', 'Удобные джинсы из денима, классический крой, прямой силуэт.',
        2999.99, TRUE, 1),
       ('Футболка белая', 'Белая хлопковая футболка',
        '100% хлопок, плотность 180 г/м², классический крой, круглый вырез.', 1499.50, TRUE, 2),
       ('Куртка зимняя', 'Теплая зимняя куртка',
        'Пуховая куртка с капюшоном, водоотталкивающая ткань, температурный режим до -25°C.', 8999.99, TRUE, 1),
       ('Платье вечернее', 'Элегантное вечернее платье',
        'Длинное платье из атласа, глубокая горловина, струящийся силуэт.', 12999.00, TRUE, 3),
       ('Кроссовки спортивные', 'Легкие спортивные кроссовки',
        'Кроссовки для бега с амортизацией, сетчатый верх, подошва из EVA.', 5499.99, TRUE, 2),
       ('Рубашка офисная', 'Классическая белая рубашка',
        'Хлопковая рубашка с длинным рукавом, классический воротник, для офиса.', 3999.00, TRUE, 1),
       ('Шапка шерстяная', 'Теплая вязаная шапка', 'Шапка из 100% шерсти мериноса, однотонная, унисекс.', 1999.50, TRUE,
        3),
       ('Брюки классические', 'Классические брюки черного цвета',
        'Брюки из костюмной ткани, стрелки, классический крой.', 4599.99, TRUE, 2),
       ('Юбка карандаш', 'Классическая юбка-карандаш',
        'Юбка из костюмной ткани, длина до колена, застежка-молния сбоку.', 3299.00, TRUE, 3),
       ('Толстовка с капюшоном', 'Удобная худи', 'Толстовка из футера, капюшон с кулиской, карман-кенгуру.', 3799.99,
        TRUE, 1);

-- Связываем товары с категориями
INSERT INTO up_category_product (category_id, product_id)
VALUES (1, 1),
       (1, 2),
       (1, 6),
       (1, 8),
       (1, 10),
       (2, 4),
       (2, 9),
       (2, 2),
       (2, 10),
       (3, 2),
       (3, 10),
       (4, 3),
       (4, 7),
       (5, 5),
       (6, 7),
       (7, 5),
       (7, 10),
       (7, 2);

-- Вставляем изображения
INSERT INTO up_image (product_id, path, is_main, width, height)
VALUES (1, '/images/products/jeans_blue_1.jpg', TRUE, 800, 1000),
       (1, '/images/products/jeans_blue_2.jpg', FALSE, 800, 1000),
       (1, '/images/products/jeans_blue_3.jpg', FALSE, 800, 1000),
       (2, '/images/products/tshirt_white_1.jpg', TRUE, 600, 800),
       (2, '/images/products/tshirt_white_2.jpg', FALSE, 600, 800),
       (3, '/images/products/jacket_winter_1.jpg', TRUE, 900, 1200),
       (3, '/images/products/jacket_winter_2.jpg', FALSE, 900, 1200),
       (3, '/images/products/jacket_winter_3.jpg', FALSE, 900, 1200),
       (4, '/images/products/dress_evening_1.jpg', TRUE, 700, 1000),
       (5, '/images/products/sneakers_sport_1.jpg', TRUE, 800, 600),
       (5, '/images/products/sneakers_sport_2.jpg', FALSE, 800, 600),
       (5, '/images/products/sneakers_sport_3.jpg', FALSE, 800, 600),
       (6, '/images/products/shirt_office_1.jpg', TRUE, 700, 900),
       (7, '/images/products/hat_wool_1.jpg', TRUE, 500, 500),
       (8, '/images/products/pants_classic_1.jpg', TRUE, 750, 1000),
       (9, '/images/products/skirt_pencil_1.jpg', TRUE, 600, 900),
       (10, '/images/products/hoodie_1.jpg', TRUE, 800, 1000),
       (10, '/images/products/hoodie_2.jpg', FALSE, 800, 1000);

-- Вставляем заказы
INSERT INTO up_order (product_id, status, total_price, client_name, client_phone, client_address, client_email)
VALUES (1, 'pending', 2999.99, 'Иван Иванов', '+79161234567', 'г. Москва, ул. Ленина, д. 10, кв. 5',
        'ivan@example.com'),
       (2, 'pending', 1499.50, 'Мария Петрова', '+79031234567', 'г. Санкт-Петербург, Невский пр., д. 25',
        'maria@example.com'),
       (3, 'paid', 8999.99, 'Алексей Смирнов', '+79261234567', 'г. Екатеринбург, ул. Мира, д. 15', 'alex@example.com'),
       (5, 'paid', 5499.99, 'Елена Кузнецова', '+79511234567', 'г. Новосибирск, ул. Советская, д. 30',
        'elena@example.com'),
       (4, 'sent', 12999.00, 'Ольга Сидорова', '+79361234567', 'г. Казань, ул. Баумана, д. 45', 'olga@example.com'),
       (6, 'sent', 3999.00, 'Дмитрий Попов', '+79461234567', 'г. Ростов-на-Дону, ул. Большая Садовая, д. 20',
        'dmitry@example.com'),
       (8, 'completed', 4599.99, 'Сергей Васильев', '+79661234567', 'г. Нижний Новгород, ул. Горького, д. 50',
        'sergey@example.com'),
       (10, 'completed', 3799.99, 'Анна Федорова', '+79761234567', 'г. Краснодар, ул. Красная, д. 100',
        'anna@example.com'),
       (7, 'cancelled', 1999.50, 'Павел Михайлов', '+79861234567', 'г. Воронеж, ул. Плехановская, д. 5',
        'pavel@example.com'),
       (9, 'cancelled', 3299.00, 'Наталья Алексеева', '+79961234567', 'г. Самара, ул. Куйбышева, д. 70',
        'natalia@example.com'),
       (1, 'pending', 2999.99, 'Андрей Николаев', '+79171234567', 'г. Уфа, ул. Ленина, д. 33', 'andrey@example.com'),
       (2, 'pending', 1499.50, 'Андрей Николаев', '+79171234567', 'г. Уфа, ул. Ленина, д. 33', 'andrey@example.com'),
       (5, 'pending', 5499.99, 'Андрей Николаев', '+79171234567', 'г. Уфа, ул. Ленина, д. 33', 'andrey@example.com');
