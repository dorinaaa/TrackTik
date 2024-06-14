# Simple PHP API Application

This project is a simple PHP API application initially built without a framework, leveraging PHP libraries for routing, dependency injection (DI), and other functionalities. However, it was later migrated to the Symfony framework for improved scalability and maintainability.

## Overview

The PHP API application serves as an intermediary between two data providers, each posting data of different schemas. The application maps the data received from the providers and posts it to the TrackTik API. To tackle this problem, the Adapter Structural design pattern and Factory pattern were implemented.

In essence, the core entity of the application is the Employee. Adapters are utilized to adapt data from providers to Employee objects and to adapt Employee objects to consumers, with TrackTik being a concrete example. Validation is added to consumer models only, as the end of the pipeline. This architecture enables easy addition of new providers and consumers, enhancing flexibility and scalability.

## Design Patterns

### Adapter Structural Design Pattern
- Adapts data from providers to the internal Employee representation.
- Adapts Employee objects to meet the requirements of consumers, such as TrackTik.

### Factory Pattern
- Facilitates the creation of appropriate instances, ensuring flexibility and ease of extension.
- Preferred over the Service Locator pattern for its suitability and simplicity, testing, control and explicitness.

## Features

- **Scalability**: The codebase is highly extensible, allowing for seamless addition of new providers and consumers.
- **Database Integration**: Future plans include implementing a database layer to enhance data management and retrieval.
- **Testing**: Work is ongoing to improve test coverage for robustness and reliability.

## Installation and Setup

1. **Clone the Repository**: `git clone <repository_url>`
2. **Install Dependencies**: `composer install`
3. **Configuration**:
- Configure environment variables that rely on Track Tik API credentials. CLIENT_SECRET, CLIENT_ID , TEMP_REFRESH_TOKEN, TEMP_ACCESS_TOKEN
4. **Run the Application**: Use Symfony's built-in server or deploy to your preferred environment.
5. **Provider Schemas**:
6. **Provider 1**:
   - Schema: `{
   "name": "john",
   "lastName": "john",
   "email": "dg@ef.come",
   "birthday": "2019-08-24",
   "gender": "M"
   }
   - Endpoint: `providers/provider1/tracktik`
   - Method: `POST`
7. **Provider 2**:
- Schema: `{
  "personalData": {
  "fullName": "John Doe",
  "sex": "M"
  },
  "contact": {
  "emailAddress": "josdhn@example.com",
  "contactNumber": "1234567890"
  },
  "address": {
  "city": "New York",
  "country": "USA",
  "street": "123 Main St",
  "postal_code": "10001"
  },
  "job": {
  "job_role": "Software Engineer"
  },
  "birth": {
  "birth_year": "1990",
  "birth_month": "10",
  "birth_day": "15"
  }
  }`
    - Endpoint: `providers/provider2/tracktik`
    - Method: `POST`
