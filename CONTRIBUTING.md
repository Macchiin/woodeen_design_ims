# Contributing to Woodeen Design IMS

Thank you for your interest in contributing to the Woodeen Design Inventory Management System! This document provides guidelines and information for contributors.

## 🤝 How to Contribute

### Reporting Issues
- Use the GitHub issue tracker to report bugs or request features
- Provide detailed information about the issue
- Include steps to reproduce bugs
- Specify your environment (OS, PHP version, browser, etc.)

### Suggesting Enhancements
- Open an issue with the "enhancement" label
- Describe the feature and its benefits
- Consider backward compatibility

## 🛠️ Development Setup

### Prerequisites
- XAMPP or similar LAMP/WAMP stack
- PHP 7.4+
- MySQL 5.7+
- Git

### Setup Process
1. Fork the repository
2. Clone your fork: `git clone https://github.com/yourusername/wooden-design-ims.git`
3. Set up the development environment following the README.md instructions
4. Create a new branch for your feature: `git checkout -b feature/your-feature-name`

## 📝 Coding Standards

### PHP
- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Add comments for complex logic
- Keep functions small and focused

### Database
- Use prepared statements for all database queries
- Follow the existing database naming conventions
- Add proper indexes for performance

### Frontend
- Use semantic HTML
- Follow CSS best practices
- Ensure responsive design
- Test across different browsers

## 🔄 Pull Request Process

1. **Fork and Branch**: Create a feature branch from `main`
2. **Code**: Implement your changes following coding standards
3. **Test**: Test your changes thoroughly
4. **Document**: Update documentation if needed
5. **Commit**: Use clear, descriptive commit messages
6. **Push**: Push your branch to your fork
7. **Pull Request**: Create a PR with a clear description

### Commit Message Format
```
type(scope): brief description

Detailed description of changes (if needed)

Fixes #issue_number (if applicable)
```

Types: `feat`, `fix`, `docs`, `style`, `refactor`, `test`, `chore`

### Pull Request Template
```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
- [ ] Tested locally
- [ ] Added/updated tests
- [ ] All tests pass

## Checklist
- [ ] Code follows style guidelines
- [ ] Self-review completed
- [ ] Documentation updated
- [ ] No breaking changes
```

## 🧪 Testing

### Manual Testing
- Test all functionality related to your changes
- Test with different user roles (admin/staff)
- Test on different browsers
- Test responsive design on mobile devices

### Database Testing
- Test with sample data
- Verify data integrity
- Check for SQL injection vulnerabilities

## 📋 Code Review Guidelines

### For Contributors
- Respond to review feedback promptly
- Be open to suggestions
- Explain complex logic if needed

### For Reviewers
- Be constructive and respectful
- Focus on code quality and functionality
- Test the changes locally when possible

## 🐛 Bug Reports

When reporting bugs, please include:

1. **Environment Details**
   - Operating System
   - PHP Version
   - MySQL Version
   - Browser and Version

2. **Steps to Reproduce**
   - Clear, numbered steps
   - Expected vs actual behavior

3. **Additional Information**
   - Error messages (if any)
   - Screenshots (if helpful)
   - Related issues

## ✨ Feature Requests

When requesting features:

1. **Problem Description**
   - What problem does this solve?
   - Who would benefit from this feature?

2. **Proposed Solution**
   - How should it work?
   - Any design considerations?

3. **Alternatives**
   - Other ways to solve the problem
   - Why this approach is preferred

## 📚 Documentation

### Code Documentation
- Comment complex functions and classes
- Use PHPDoc for function documentation
- Keep README.md updated

### User Documentation
- Update user guides for new features
- Include screenshots for UI changes
- Maintain installation instructions

## 🔒 Security

### Security Guidelines
- Never commit passwords or API keys
- Use prepared statements for database queries
- Validate and sanitize all user input
- Follow OWASP guidelines

### Reporting Security Issues
- **DO NOT** open public issues for security vulnerabilities
- Email security concerns to: your-email@example.com
- Include detailed information about the vulnerability

## 📞 Getting Help

- **GitHub Issues**: For bugs and feature requests
- **Discussions**: For general questions and ideas
- **Email**: your-email@example.com for private matters

## 🏆 Recognition

Contributors will be recognized in:
- CONTRIBUTORS.md file
- Release notes for significant contributions
- GitHub contributors list

## 📄 License

By contributing, you agree that your contributions will be licensed under the MIT License.

---

Thank you for contributing to Wooden Design IMS! 🎉

