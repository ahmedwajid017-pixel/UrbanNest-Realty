# UrbanNest Realty – Security Review

## 1. Authentication

The application uses Laravel Breeze for user registration, login, and logout. Passwords are hashed before being stored in the database. Authentication middleware protects routes that require a logged-in user.

Laravel's web middleware provides CSRF protection for state-changing requests. Forms use the `@csrf` directive to include CSRF tokens.

## 2. Authorization and Role-Based Access Control

The application implements custom role-based access control with three roles: Owner, Agent, and Staff.

- **Owner:** Can view, create, update, and delete all properties.
- **Agent:** Can manage only properties assigned to their agent account.
- **Staff:** Can view property listings but cannot create, update, or delete properties.

Custom `CheckRole` middleware protects admin routes, while `PropertyPolicy` checks permissions for individual property operations.

## 3. Input Validation

The application uses Laravel Form Request validation to validate property data and uploaded images.

Image upload restrictions include:
- Only JPG, JPEG, PNG, and WEBP formats are accepted.
- Maximum 10 images per upload request.
- Maximum file size of 5 MB per image.

Invalid requests are rejected by server-side validation.

## 4. Mass Assignment Protection

Laravel model `$fillable` attributes define which fields can be assigned through mass assignment.

Sensitive user fields, including `role_id` and `agent_id`, are not included in the User model's fillable attributes. Agent property creation and updates also enforce the authenticated agent's ownership in the controller.

## 5. XSS Protection

Laravel Blade templates escape output by default when using `{{ }}`. This helps prevent malicious HTML and JavaScript from being executed in displayed content.

Untrusted user input should not be rendered using unescaped Blade output such as `{!! !!}`.

## 6. File Upload Security

Uploaded property images are validated on the server before storage. Files are stored using Laravel's public storage disk rather than being directly placed in application source directories.

Property operations are protected by authorization policies. Agents can only manage properties assigned to their agent account. Uploaded images are validated before storage, and image deletion is performed through the application's authorized property management flow.

## 7. Security Recommendations

- Keep Laravel and Composer dependencies updated.
- Use strong passwords and protect environment configuration.
- Never commit `.env` files or database credentials to GitHub.
- Use HTTPS in production.
- Review authorization rules whenever new routes or property operations are added.
- Run dependency security audits regularly.

## Conclusion

UrbanNest Realty uses Laravel authentication, custom role-based middleware, policies, server-side validation, and mass assignment protection to improve application security. Security checks should be repeated whenever new features are introduced.