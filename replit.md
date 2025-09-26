# Nerds of a Feather - Authentication System

## Project Overview
A PHP-based web application with user authentication features. The application allows users to sign up and log in with session management.

## Architecture
- **Frontend**: HTML/CSS/JavaScript with responsive design
- **Backend**: PHP with built-in web server
- **Database**: SQLite for user data and session management
- **API**: RESTful endpoints for authentication

## Recent Changes (September 26, 2025)
- Converted from GitHub import to work in Replit environment
- Migrated from MySQL to SQLite database
- Fixed API endpoint paths and database connections
- Updated JavaScript to use Replit domain URLs
- Configured PHP server with proper host binding (0.0.0.0:5000)
- Set up workflow and deployment configuration

## Project Structure
```
├── API/
│   ├── login.php      # User login endpoint
│   └── signup.php     # User registration endpoint
├── Config/
│   └── database.php   # Database connection class
├── Models/
│   └── User.php       # User model with authentication methods
├── index.html         # Main frontend interface
├── updated.js         # JavaScript for API communication
├── router.php         # PHP router for built-in server
├── database_setup.sql # SQLite database schema
└── nerds_feather.db   # SQLite database file
```

## Database Schema
- **users**: User accounts with username, password hash, email
- **user_profiles**: Additional user information
- **user_sessions**: Session management with tokens and expiration

## API Endpoints
- `POST /API/signup.php` - User registration
- `POST /API/login.php` - User authentication

## Default Credentials
- Username: admin
- Password: password

## Development Notes
- Server runs on port 5000 with PHP built-in server
- Database automatically initializes on first connection
- Session tokens are generated for authenticated users
- SQLite parameter binding required manual comparison workaround

## User Preferences
- Uses modern dark theme design
- Responsive layout for mobile compatibility
- Clean authentication forms with validation