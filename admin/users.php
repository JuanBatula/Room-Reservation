<?php
include '../connect.php';
include '../includes/header.php';

$result = mysqli_query($connection, "SELECT * FROM tbuser");

/*
$result = mysqli_query($connection, "SELECT u.* FROM tbuser u 
          INNER JOIN tbstudent s ON u.user_id = s.user_id");
*/
?>

<link rel="stylesheet" href="../styles/users.css">

<div class="topbar">
    <div class="topbar-left">
        <div class="topbar-accent"></div>
        <h1>User Management</h1>
    </div>
</div>
<div class="gold-bar"></div>

<div class="page">

    <div class="table-wrap">
        <table id="usersTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)){ ?>
                <tr>
                    <td>
                        <div class="user-name"><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></div>
                    </td>
                    <td>
                        <div class="user-email"><?php echo htmlspecialchars($row['email']); ?></div>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="edit_user.php?id=<?php echo $row['user_id']; ?>" class="btn-edit">Edit</a>
                            <a href="delete_user.php?id=<?php echo $row['user_id']; ?>"
                               class="btn-del"
                               onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="pg-row">
        <span class="pg-info" id="pgInfoUsers"></span>
        <div class="pg-btns" id="pgBtnsUsers"></div>
    </div>

</div>

<script>
(function () {
    const ROWS_PER_PAGE = 8;
    const tbody = document.querySelector('#usersTable tbody');
    const rows  = Array.from(tbody.querySelectorAll('tr'));
    const info  = document.getElementById('pgInfoUsers');
    const btns  = document.getElementById('pgBtnsUsers');
    let current = 1;

    function totalPages() {
        return Math.max(1, Math.ceil(rows.length / ROWS_PER_PAGE));
    }

    function render(page) {
        current = page;
        const start = (page - 1) * ROWS_PER_PAGE;
        const end   = start + ROWS_PER_PAGE;

        rows.forEach((row, i) => {
            row.style.display = (i >= start && i < end) ? '' : 'none';
        });

        const total = totalPages();
        info.textContent = `Showing ${Math.min(start + 1, rows.length)}–${Math.min(end, rows.length)} of ${rows.length} users`;

        btns.innerHTML = '';

        const prev = document.createElement('button');
        prev.className = 'pg-btn';
        prev.textContent = '‹';
        prev.disabled = page === 1;
        prev.onclick = () => render(current - 1);
        btns.appendChild(prev);

        for (let p = 1; p <= total; p++) {
            const btn = document.createElement('button');
            btn.className = 'pg-btn' + (p === page ? ' active' : '');
            btn.textContent = p;
            btn.onclick = () => render(p);
            btns.appendChild(btn);
        }

        const next = document.createElement('button');
        next.className = 'pg-btn';
        next.textContent = '›';
        next.disabled = page === total;
        next.onclick = () => render(current + 1);
        btns.appendChild(next);
    }

    render(1);
})();
</script>

<?php include '../includes/footer.php'; ?>