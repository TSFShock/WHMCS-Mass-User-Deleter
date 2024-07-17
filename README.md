
# Mass Delete Accounts WHMCS Addon

**Mass Delete Accounts** is a WHMCS addon that allows administrators to delete multiple user accounts simultaneously. This tool is particularly useful for managing large volumes of accounts and ensuring your client database is clean and up-to-date.

## Features

- Delete multiple accounts in a single action.
- Filter accounts by status (active or inactive).
- User-friendly interface for selecting and deleting accounts.

## Installation

1. **Download the Files:**
   Download the addon files from the GitHub repository.

2. **Upload to WHMCS:**
   Upload the contents of the `massDeleteAccounts` directory to the `modules/addons` directory of your WHMCS installation.

3. **Activate the Addon:**
   - Navigate to the WHMCS admin area.
   - Go to `Setup > Addon Modules`.
   - Find `Mass Delete Accounts` and click on the `Activate` button.
   - Configure any necessary settings.

4. **Configure Access Control:**
   - Go to `Setup > Staff Management > Administrator Roles`.
   - Ensure the desired admin roles have access to the addon.

## Usage

1. **Navigate to the Addon:**
   - In the WHMCS admin area, go to `Addons > Mass Delete Accounts`.

2. **Filter Accounts:**
   - Use the filter options to display active or inactive accounts, or show all accounts.

3. **Select Accounts:**
   - Check the boxes next to the accounts you wish to delete.
  

4. **Delete Accounts:**
   - Click the "Delete Selected Accounts" button.
   - Confirm the deletion when prompted.
  

## Code Overview

### Activation and Deactivation

```php
function massDeleteAccounts_activate() {
    return [
        'status' => 'success',
        'description' => 'Module activated successfully.',
    ];
}

function massDeleteAccounts_deactivate() {
    return [
        'status' => 'success',
        'description' => 'Module deactivated successfully.',
    ];
}
```

### Main Output Function

```php
function massDeleteAccounts_output($vars) {
    // Add your implementation here
}
```

### Delete Function

```php
function massDeleteAccounts_delete() {
    // Add your implementation here
}
```

### Helper Functions

```php
function getAllAccounts($filter) {
    // Add your implementation here
}

function deleteAccount($accountId) {
    // Add your implementation here
}
```

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request with your changes.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

