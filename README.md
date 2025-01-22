
---

# Hotel, Apartment, and Vehicle Reservation Web App

## Project Overview

This project aims to develop a web application that allows users to book hotel rooms, apartments, and vehicles. The platform will provide real-time availability of hotels, rooms, apartments, and vehicles. It also includes an admin panel for managing system content and staff, as well as a user-friendly interface for booking reservations. The system will feature a secure payment infrastructure and ensure ease of use for all parties.



## Features

- **Admin Panel:** Manage content for hotels, apartments, and vehicles.
- **Real-time Availability:** Users can see the availability of rooms and vehicles.
- **User-Friendly Interface:** Simple and fast reservation process for users.
- **Real-Time Updates:** Check availability in real-time for rooms and vehicles.
- **Secure Payments:** A secure payment infrastructure for processing transactions.

## Technologies Used

### Front-End
- **HTML**
- **CSS**
- **JavaScript**
- **SvelteKit** (Framework)

### Back-End
- **Laravel** (Framework)
- **API** for managing hotel and vehicle owners.

### Database
- **MySQL** (Database for managing hotel, room, vehicle, and user information)

## Setup Instructions

1. **Clone the Repository:**

   ```bash
   git clone https://github.com/HozefaSelim/Reservation-Sistem.git
   ```

2. **Install Dependencies:**

   Navigate to the project directory and install the required dependencies for both the front-end and back-end.

   For the front-end:

   ```bash
   cd frontend
   npm install
   ```

   For the back-end:

   ```bash
   cd backend
   composer install
   ```

3. **Set Up Environment:**

   Create a `.env` file in the back-end directory and configure your database settings.

4. **Run the Application:**

   To start the development server for the front-end:

   ```bash
   npm run dev
   ```

   To start the Laravel server:

   ```bash
   php artisan serve
   ```

5. **Database Setup:**

   Run the migrations for setting up the database:

   ```bash
   php artisan migrate
   ```

## Contributing

Feel free to fork this repository and submit pull requests. Please ensure your contributions follow the coding standards and include proper documentation.


---

