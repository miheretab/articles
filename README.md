Articles Features
=================
- Application is done in cakephp 2.x, as DB - MySQL
- Simple signup(first name, last name, email with password)
- Login
- Password recovery
- Edit password in account
*******************************
Two user types: User and Admin
*******************************
1) User
-------
- Users can register and when logged in can add/edit/activate/suspend/delete their own articles.
- If article is active it can be shown publicly on the website to all users.
- If article is suspended only the owner can see it, but it will not be shown on the public website.

2) Admin
---------
- Admin can see the list of/information of all users and suspend/activate/delete them
- Admin can also see the list of all articles of all users and edit/activate/suspend/delete them.

3) Visitors
------------
- In the website, the visitors can see the list of active articles, and when clicking  on them go to  the article's  
view page, where we will have the title and the content.

4) User balance
-----------------
- Users can add money to their balance, for that they click "Add balance" button, and on that page fill in the 
form with CC number, CVC, expiration date, first name and last name, choose the amount that they want to 
add to their account and submit, and we are adding that  amount to their current balance (if successful  –  or 
show error message otherwise)
- Users can see their current balance when they are logged in.

5) Cron
--------
- A small shell, to work as a cron job to run regularly, that charges the clients - by taking some amount from 
their balance. It should simply decrease each users balance by some amount, as simple as that.

