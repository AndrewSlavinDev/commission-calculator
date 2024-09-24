# **Commission Calculator**

## **Overview**

This application calculates commissions for transactions based on the credit card's BIN (Bank Identification Number), transaction amount, and currency. Different commission rates are applied for EU-issued and non-EU-issued cards. The entire calculation process is based on the country from the BIN, the exchange rates for the currency, and the amount of the transaction.

This project follows the **SOLID principles**, with special attention to the **Single Responsibility** and **Dependency Inversion** principles. The solution is modular, allowing for easy changes in external services like the BIN provider or currency exchange rate provider without impacting the main logic.

---

## **Features**

1. **Commission Calculation**: Calculates commission for transactions based on the country of origin of the card (via BIN) and the transaction currency.
2. **Integration with External APIs**:
    - BIN Provider (`https://lookup.binlist.net/`) to fetch the country of the card issuer.
    - Exchange Rate Provider (`https://api.exchangeratesapi.io/latest`) to convert foreign currencies to EUR.
3. **EU Card Check**: Applies different rates depending on whether the card was issued within the European Union.
4. **Cents Ceiling**: Rounds up commissions to the nearest cent.
5. **Testable and Extendable**: The solution is structured to allow easy replacement of external services and can be tested independently via mocks.

---

## **Requirements**

- PHP 8.0 or higher
- Composer (to install dependencies)
- External APIs:
    - [BIN List API](https://lookup.binlist.net/)
    - [Exchange Rate API](https://exchangeratesapi.io/)

---

## **Installation**

### 1. **Clone the Repository**:

   ```bash
   git clone https://github.com/AndrewSlavinDev/commission-calculator.git
   cd commission-calculator
   ```
 
   
### 2. **Install Dependencies**:

Ensure you have Composer installed, then run the following command to install all required dependencies:

   ```bash 
    composer install
   ```

---

## **Configuration**

Ensure the required API services are properly set up. If you need authentication for future versions of the API (e.g., for Exchange Rate), you may add your credentials to a .env file (not required for this demo as the APIs are public).

---

## **Usage**

To calculate commissions, you need to pass the transaction data through a file. The input format should be JSON (one transaction per line) with the following structure:

```json
{"bin":"45717360","amount":"100.00","currency":"EUR"}
{"bin":"516793","amount":"50.00","currency":"USD"}
```

You can run the app using the following command:

```bash
php app.php input.txt
```

**Example Output**:

```bash
1
0.47
```

This output represents the commission for each transaction based on the input data.

---

## **Testing**

The solution uses PHPUnit for testing. Unit tests for `CommissionCalculator` and related services have been written to mock external dependencies (like the BIN and exchange rate APIs).

To run tests:

1. Install PHPUnit:

```bash
composer require phpunit/phpunit --dev
```
2. Install Mockery:

```bash
composer require mockery/mockery --dev
```
3. Execute the tests:

```bash
./vendor/phpunit/phpunit/phpunit
```

The tests ensure that the commission calculations are accurate, even if the external services return different values. Mocks are used to control the API responses in the tests.

---

## **Extensibility**

This project is designed to be easily extensible. You can replace the BIN or exchange rate providers without modifying the `CommissionCalculator`. Just create new classes that implement the respective service interfaces:

- `BinServiceInterface`
- `ExchangeRateServiceInterface`
- `EuCountryServiceInterface`

For example, if you need to use a different exchange rate API with authentication, you can create a new class implementing `ExchangeRateServiceInterface` and inject it.

---

## **Code Structure**

- Contracts: Contains the interfaces for services.
- Services: Contains the business logic and integration with external APIs.
- Tests: Unit tests for the commission calculator and services.

---

## **Improvements and Future Work**

- Implement caching for API responses to reduce the number of requests.
- Add authentication support for the APIs if needed.
- Replace the external services (like the exchange rate or BIN provider) with more robust options.
- Add database integration for logging transactions or historical data.

---

## **License**

This project is open-source and available under the MIT License.