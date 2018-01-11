# Implementation

Your mission for this project is to implement C$75 Finance, a website that allows users 
to manage portfolios of stocks. The overall design and aesthetics of this site are ultimately 
up to you, but we require that your site meet some requirements. All other details are left to 
your own creativity and interpretation.

## Feature Requirements.
* <span style="color: red; font-weight: bold">DONE.</span> Your site must require that a user log in with a username and password in order to see or do anything (except, obviously, log in or register).
* <span style="color: red; font-weight: bold">DONE.</span> Your site must allow a user to register for an account. A user’s username must be a syntactically valid email address. A user’s password must be at least six characters, and it cannot be entirely alphabetic or entirely numeric. Upon registering, a user should receive a free gift: $10,000 in cash.
* <span style="color: red; font-weight: bold">DONE.</span> Your site must allow a user to get a quote (i.e., look up its “Last Trade” price) for a stock by providing its symbol.
* <span style="color: red; font-weight: bold">DONE.</span> Your site must allow a user to buy shares of a stock by providing its symbol; your site must allow a user to buy more shares of a stock that he or she already owns. A user may not buy fractions of shares.
* <span style="color: red; font-weight: bold">DONE.</span> Your site must allow a user to sell shares of a stock that he or she already owns; for simplicity, you may require that a user sell all or none rather than some. A user may not sell fractions of shares.
* <span style="color: red; font-weight: bold">DONE.</span> Your site must allow a user to check the current value of his or her portfolio (i.e., his or her cash plus his or her stocks’ value based on its “Last Trade” price).
* Your site must perform client-side validation, where possible, of user input related to a buy or a sell. For instance, if some text field must contain a non-negative integer (e.g., number of shares to buy or sell), you must reject attempts to submit invalid input (as by admonishing the user with an alert) or prevent them from typing anything non-numeric at all.
* On any page designed to take user input, you should give focus (via JavaScript) to the first field requiring the user’s attention (e.g., the username field on your login page).
* Your site must perform rigorous server-side error-checking. Under no circumstances should we be able to crash your site or induce unreasonable behavior. Letting us sell more shares than we own is not, shall we say, reasonable. We will bang on your code and try to find faults; do not let us succeed.
* Your website must appear and behave the same on the latest versions of at least two of these browsers: