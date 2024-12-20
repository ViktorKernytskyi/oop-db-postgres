# User Data Management Project

## **Description**  
This project is a PHP application designed for managing user data using an object-oriented programming approach, with PostgreSQL as the database backend. It allows adding, editing, viewing, and deleting user records.

---

## **Basic Technologies**  
- **PHP**: Leveraging PDO for secure database interactions.  
- **PostgreSQL**: Backend database system.  
- **OpenServer**: Local development environment.  

---

## **Main Components**  

### **Classes**  
1. **`Database`**: Manages the database connection.  
2. **`User`**: Handles CRUD operations for user data.  

### **Files**  
- **`index.php`**: Main page displaying the user list.  
- **`add.php`**: Form for adding a new user.  
- **`edit.php`**: Form for editing user information.  
- **`delete.php`**: Logic for handling user deletion.  
- **`config.php`**: Configuration file for database connection settings.  
- **`Database.php`**: Class for database connection logic.  
- **`User.php`**: Class implementing user data operations.  

---

## **Functionalities**  
1. View the list of all users.  
2. Add a new user.  
3. Edit existing user information.  
4. Delete user records.  

---

## **Setup Instructions**  
1. Clone the repository to your local machine.  
2. Configure the database connection in `config.php`.  
3. Ensure **OpenServer** is running.  
4. Create the PostgreSQL database and define the `users` table with the following fields:  
   - **`id`**: Primary key  
   - **`first_name`**: User's first name  
   - **`last_name`**: User's last name  
   - **`email`**: User's email address  
   - **`phone`**: User's phone number  

---

## **Usage**  
- Open `index.php` in your web browser to view the user list and interact with the application.  
- Use the **add** and **edit** forms for managing user records.  

---

## **Features**  
- Secure database queries using prepared statements.  

