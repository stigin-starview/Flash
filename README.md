# Flash Framework

Flash is a lightweight PHP framework created for educational purposes, designed to help understand the fundamentals of framework architecture. It provides all the essential functionalities needed to build a basic application, with ongoing updates to enhance its features.

---

## Features

- **Routing**: Define and manage application routes effortlessly.
- **Database Interaction**: ORM-style database handling for easy queries.
- **Validation**: Built-in validation for user input.
- **Templating**: (Work in Progress) Render dynamic views seamlessly.
- **Middleware**: (Work in Progress) Add custom logic to request and response cycles.
- **MVC Architecture**: Built with a Model-View-Controller pattern for structured development.
- **Environment File Support**: Configure your application via a `.env` file.
- **Dependency Injection**: Simplify dependency management and testing.
- **PHPUnit Tests**: Write and execute unit tests for your application.

---

## Installation

1. Clone the repository:
   ```bash
   git clone <repository-url>
   ```
2. Install dependencies:
   ```bash
   ./bin/install
   ```
   

3. Ensure you have PHP installed and configured. For ease of use, consider using [MAMP](https://www.mamp.info) for your server and database setup.

---

## Usage

1. **Setup**: Add your database credentials in the `.env` file located at the root of your project.
2. **Creating a View**:
    - Define a view in the `src/view` directory.
3. **Routing**:
    - Add a route in the router to point to a specific URL.
4. **Controllers**:
    - Connect the route to a controller in the `src/controller` directory.
5. **Complete the Flow**:
    - Ensure the controller points to the appropriate view.
    - Use the provided templates for consistency and to leverage all framework functionalities.

### Code Example

```php
// Example route definition
$router->add('GET', '/messages', 'MessageBoxController@index');

// Example controller method
public function index(): ViewService
{
    $messages = $this->repository->getAllMessages();
    return new ViewService('messageBoxView', ['messages_box' => $messages]);
}
```

---

## Directory Structure

The Flash framework follows the MVC (Model-View-Controller) structure. Below is the directory layout:

```
flash/
│
├── src/
│   ├── Controller/    # Handles user requests
│   ├── Model/         # Represents and manages data
│   ├── View/          # Contains templates for the user interface
│
├── config/            # Configuration files
├── System/            # Core framework logic (e.g., routing, validation)
├── public/            # Publicly accessible files (e.g., index.php, assets)
└── .env               # Environment-specific settings
```

*Note*: Future updates may transition to a DDD (Domain-Driven Design) structure.

---

## Contributing

This is a personal project and is not open for external contributions at the moment.

---

## License

No license is currently applied to this project.

---

## Support

For any issues or suggestions, feel free to raise them on the GitHub repository.

