# Запуск проекта (Apache + Vite + Vue)

Данный проект использует классическую серверную архитектуру:
- Apache + PHP — сервер и управление страницей
- Vite — сборщик фронтенда
- Vue — интерфейс приложения

Node.js **не используется в продакшене** и нужен только для сборки.

---

## 1. Настройка VirtualHost Apache

Добавьте виртуальный хост в конфигурацию Apache:

```apache
<VirtualHost *:80>
  ServerName eshop.bx
  DocumentRoot /var/www/eshop.bx/public

  <Directory /var/www/eshop.bx/public>
    AllowOverride All
    Require all granted
  </Directory>
</VirtualHost>

Важно:
	•	DocumentRoot обязательно должен указывать на папку public
	•	Apache не должен смотреть в frontend или backend

После изменений перезагрузите Apache.

⸻

2. Добавление домена в hosts

Чтобы домен открывался локально, добавьте запись в файл /etc/hosts:

127.0.0.1   eshop.bx

Без этого шага браузер не сможет открыть сайт по домену.

⸻

3. Подготовка проекта после установки

После распаковки или клонирования проекта:

Установка зависимостей фронтенда

Перейдите в папку frontend и выполните:

npm install

Папка node_modules не хранится в репозитории и устанавливается локально.

Перейдите в папку backend и выполните:

composer install

⸻

4. Dev-режим (разработка)

Шаг 1. Включите dev-режим в backend

В файле backend/config/settings.php:

'debug' => [
  'value' => true,
  ...
]

Шаг 2. Запустите Vite dev server

cd frontend
npm run dev

В результате:
	•	ассеты отдаются через Vite
	•	Vue работает в dev-режиме
	•	доступны Vue DevTools

⸻

5. Prod-режим (публикация билда)

Шаг 1. Отключите dev-режим в backend

В файле backend/config/settings.php установите debug = false.

Шаг 2. Соберите фронтенд

cd frontend
npm run release

В результате:
	•	обновляется папка public/assets
	•	обновляется файл public/.vite/manifest.json
	•	Node.js больше не нужен для работы сайта

Эти файлы являются результатом сборки фронтенда
и должны быть добавлены в репозиторий.

⸻

Ключевые принципы архитектуры
	•	Apache — HTTP сервер
	•	PHP — управляет страницей и данными
	•	Vite — сборщик ассетов
	•	Vue — интерфейс
	•	Node.js используется только на этапе разработки

⸻

Проверка запуска

Проект считается корректно запущенным, если:
	•	сайт открывается по адресу http://eshop.bx
	•	существует папка public/assets
	•	существует файл public/.vite/manifest.json
	•	Vue-приложение монтируется
	•	стили подключены корректно