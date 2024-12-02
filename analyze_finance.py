import pandas as pd
import mysql.connector
import json

# Fetch data from MySQL database
def fetch_data_from_db():
    try:
        # Connect to MySQL database
        connection = mysql.connector.connect(
            host="localhost",
            user="root",  # Replace with your MySQL username
            password="",  # Replace with your MySQL password
            database="personal"
        )
        query = "SELECT salary, expense_type, expense, total_left_balance, record_date FROM info_history"
        data = pd.read_sql(query, connection)
        print("Data fetched successfully!")
        return data
    except mysql.connector.Error as e:
        print(f"Error connecting to database: {e}")
        return None
    finally:
        if connection.is_connected():
            connection.close()

# Analyze spending trends
def analyze_data(data):
    # Calculate total salary, total expense, and remaining balance
    total_salary = data['salary'].sum()
    total_expense = data['expense'].sum()
    balance_left = data['total_left_balance'].iloc[-1]  # Latest balance

    # Spending by category
    spending_by_category = data.groupby('expense_type')['expense'].sum().to_dict()

    # Suggestions
    suggestions = []
    if total_expense > 0.8 * total_salary:
        suggestions.append("⚠️ You are spending more than 80% of your salary. Consider cutting back on non-essential expenses.")
    for category, amount in spending_by_category.items():
        if amount > 0.3 * total_salary:
            suggestions.append(f"⚠️ High spending on {category}: ${amount:.2f}. Consider reducing costs in this area.")

    return {
        "total_salary": total_salary,
        "total_expense": total_expense,
        "balance_left": balance_left,
        "spending_by_category": spending_by_category,
        "suggestions": suggestions
    }

# Save results as JSON for PHP
def save_results_to_json(results, filename="analysis_results.json"):
    with open(filename, "w") as file:
        json.dump(results, file)
    print(f"Results saved to {filename}")

# Main Function
def main():
    data = fetch_data_from_db()
    if data is not None:
        analysis_results = analyze_data(data)
        save_results_to_json(analysis_results)

if __name__ == "__main__":
    main()
