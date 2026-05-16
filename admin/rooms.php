<?php
include '../connect.php';
include '../includes/header.php';

$totalRooms    = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) c FROM tbroom"))['c'];
$totalAvail    = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) c FROM tbroom WHERE status='Available'"))['c'];
$totalOccupied = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) c FROM tbroom WHERE status='Occupied'"))['c'];
$totalUnavail  = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) c FROM tbroom WHERE status='Unavailable'"))['c'];

$search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';
$filter = isset($_GET['filter']) ? mysqli_real_escape_string($connection, $_GET['filter']) : '';

$where = "WHERE 1=1";
if ($search) $where .= " AND room_name LIKE '%$search%'";
if ($filter) $where .= " AND status='$filter'";

$result = mysqli_query($connection, "SELECT * FROM tbroom $where ORDER BY room_id ASC");
?>

<link rel="stylesheet" href="../styles/rooms.css">

<div class="topbar">
    <div class="topbar-left">
        <div class="topbar-accent"></div>
        <h1>Room management</h1>
    </div>
    <a href="add_room.php" class="btn-add">+ Add room</a>
</div>
<div class="gold-bar"></div>

<div class="page">

    <div class="stats">
        <div class="stat">
            <div class="stat-label">Total rooms</div>
            <div class="stat-val"><?php echo $totalRooms; ?></div>
        </div>
        <div class="stat gold-accent">
            <div class="stat-label">Available</div>
            <div class="stat-val"><?php echo $totalAvail; ?></div>
        </div>
        <div class="stat">
            <div class="stat-label">Occupied</div>
            <div class="stat-val"><?php echo $totalOccupied; ?></div>
        </div>
        <div class="stat">
            <div class="stat-label">Unavailable</div>
            <div class="stat-val gray"><?php echo $totalUnavail; ?></div>
        </div>
    </div>

    <form method="GET" class="search-row">
        <div class="search-wrap">
            <input type="text" name="search" placeholder="Search by room name…"
                   value="<?php echo htmlspecialchars($search); ?>">
        </div>
        <select name="filter" class="filter-select" onchange="this.form.submit()">
            <option value="">All statuses</option>
            <option value="Available"   <?php if ($filter === 'Available')   echo 'selected'; ?>>Available</option>
            <option value="Occupied"    <?php if ($filter === 'Occupied')    echo 'selected'; ?>>Occupied</option>
            <option value="Unavailable" <?php if ($filter === 'Unavailable') echo 'selected'; ?>>Unavailable</option>
        </select>
        <button type="submit" class="btn-add">Search</button>
    </form>

    <div class="table-wrap">
        <table id="roomsTable">
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)):
                    $status = $row['status'];
                    if ($status === 'Available')        $badgeClass = 'badge-available';
                    elseif ($status === 'Occupied')     $badgeClass = 'badge-occupied';
                    else                                $badgeClass = 'badge-unavailable';
                ?>
                <tr>
                    <td>
                        <div class="room-name"><?php echo htmlspecialchars($row['room_name']); ?></div>
                    </td>
                    <td>
                        <div class="cap"><?php echo $row['capacity']; ?> pax</div>
                    </td>
                    <td>
                        <span class="badge <?php echo $badgeClass; ?>"><?php echo $status; ?></span>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="edit_room.php?id=<?php echo $row['room_id']; ?>" class="btn-edit">Edit</a>
                            <a href="delete_room.php?id=<?php echo $row['room_id']; ?>" class="btn-del"
                               onclick="return confirm('Delete this room?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="pg-row">
        <span class="pg-info" id="pgInfoRooms"></span>
        <div class="pg-btns" id="pgBtnsRooms"></div>
    </div>

</div>

<script>
(function () {
    const ROWS_PER_PAGE = 8;
    const tbody = document.querySelector('#roomsTable tbody');
    const rows  = Array.from(tbody.querySelectorAll('tr'));
    const info  = document.getElementById('pgInfoRooms');
    const btns  = document.getElementById('pgBtnsRooms');
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
        info.textContent = `Showing ${Math.min(start + 1, rows.length)}–${Math.min(end, rows.length)} of ${rows.length} rooms`;

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