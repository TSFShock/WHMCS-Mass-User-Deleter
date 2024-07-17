<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function massDeleteAccounts_config() {
    return [
        'name' => 'Mass Delete Accounts',
        'description' => 'An addon to mass delete multiple accounts in WHMCS.',
        'version' => '1.1',
        'author' => 'Bailey Shelhorse',
        'fields' => []
    ];
}

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

function massDeleteAccounts_output($vars) {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $filter = isset($_GET['filter']) ? $_GET['filter'] : '';

    echo '<style>
            table.mass-delete-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            table.mass-delete-table th, table.mass-delete-table td {
                border: 1px solid #ddd;
                padding: 8px;
            }
            table.mass-delete-table th {
                background-color: #f2f2f2;
                text-align: left;
            }
            table.mass-delete-table tr:nth-child(even) {
                background-color: #f9f9f9;
            }
            table.mass-delete-table tr:hover {
                background-color: #ddd;
            }
            .mass-delete-container {
                margin-bottom: 20px;
            }
            .mass-delete-button {
                padding: 10px 15px;
                background-color: #007bff;
                color: white;
                border: none;
                cursor: pointer;
            }
            .mass-delete-filter a {
                margin-right: 10px;
                text-decoration: none;
                color: #007bff;
            }
          </style>';

    if ($action == 'delete') {
        massDeleteAccounts_delete();
    } else {
        $accounts = getAllAccounts($filter);
        $filterUrl = 'addonmodules.php?module=massDeleteAccounts&filter=';

        echo '<div class="mass-delete-filter">';
        echo '<a href="' . $filterUrl . 'active">Active Users</a>';
        echo '<a href="' . $filterUrl . 'inactive">Inactive Users</a>';
        echo '<a href="addonmodules.php?module=massDeleteAccounts">Show All</a>';
        echo '</div>';

        echo '<form method="post" action="addonmodules.php?module=massDeleteAccounts&action=delete">';
        echo '<table class="mass-delete-table">';
        echo '<tr><th>Select</th><th>Client ID</th><th>Client Name</th><th>Email</th><th>Main Domain</th><th>Status</th></tr>';
        foreach ($accounts as $account) {
            echo '<tr>';
            echo '<td><input type="checkbox" name="accounts[]" value="' . $account['id'] . '"></td>';
            echo '<td>' . $account['id'] . '</td>';
            echo '<td>' . $account['name'] . '</td>';
            echo '<td>' . $account['email'] . '</td>';
            echo '<td>' . $account['domain'] . '</td>';
            echo '<td>' . ucfirst($account['status']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '<div><input type="submit" value="Delete Selected Accounts" class="mass-delete-button"></div>';
        echo '</form>';
    }
}

function massDeleteAccounts_delete() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $accountsToDelete = isset($_POST['accounts']) ? $_POST['accounts'] : [];

        if (!empty($accountsToDelete)) {
            foreach ($accountsToDelete as $accountId) {
                deleteAccount($accountId);
            }
            echo 'Selected accounts have been deleted.';
        } else {
            echo 'No accounts selected for deletion.';
        }
    }
}

function getAllAccounts($filter) {
    $accounts = [];
    $where = "";

    if ($filter == 'active') {
        $where = "WHERE tblclients.status = 'Active'";
    } elseif ($filter == 'inactive') {
        $where = "WHERE tblclients.status = 'Inactive'";
    }

    $query = "
        SELECT tblclients.id, CONCAT(tblclients.firstname, ' ', tblclients.lastname) AS name, tblclients.email, tblclients.status,
               (SELECT domain FROM tblhosting WHERE tblhosting.userid = tblclients.id LIMIT 1) AS domain
        FROM tblclients
        $where
    ";
    $result = full_query($query);

    while ($row = mysql_fetch_assoc($result)) {
        $accounts[] = $row;
    }
    return $accounts;
}

function deleteAccount($accountId) {
    $accountId = (int)$accountId;
    $query = "DELETE FROM tblclients WHERE id = {$accountId}";
    full_query($query);
}

?>
