<?php
include '../connect.php';
include '../includes/header.php';

$totalRooms    = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) c FROM tbroom"))['c'];
$totalAvail    = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) c FROM tbroom WHERE status='Available'"))['c'];
$totalOccupied = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) c FROM tbroom WHERE status='Occupied'"))['c'];
$totalUnavail  = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) c FROM tbroom WHERE status='Unavailable'"))['c'];

$result = mysqli_query($connection, "SELECT * FROM tbroom ORDER BY room_id ASC");
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

    <div class="tab-row">
        <button class="tab-btn active" data-filter="">All</button>
        <button class="tab-btn" data-filter="Available">Available</button>
        <button class="tab-btn" data-filter="Occupied">Occupied</button>
        <button class="tab-btn" data-filter="Unavailable">Unavailable</button>
    </div>

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
                <tr data-status="<?php echo $status; ?>">
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

    <!-- Fixed-height pagination area so buttons never shift position -->
    <div class="pg-row">
        <span class="pg-info" id="pgInfoRooms"></span>
        <div class="pg-btns" id="pgBtnsRooms"></div>
    </div>

</div>

<script>
(function () {
    const ROWS_PER_PAGE = 5;
    const tbody   = document.querySelector('#roomsTable tbody');
    const allRows = Array.from(tbody.querySelectorAll('tr'));
    const info    = document.getElementById('pgInfoRooms');
    const btns    = document.getElementById('pgBtnsRooms');
    const tabs    = document.querySelectorAll('.tab-btn');

    let current    = 1;
    let activeFilter = '';
    let visibleRows  = allRows;

    function getFiltered() {
        return activeFilter
            ? allRows.filter(r => r.dataset.status === activeFilter)
            : allRows;
    }

    function totalPages(rows) {
        return Math.max(1, Math.ceil(rows.length / ROWS_PER_PAGE));
    }

    function render(page) {
        current     = page;
        visibleRows = getFiltered();

        const total = totalPages(visibleRows);
        // clamp in case filter shrinks the page count
        if (current > total) current = total;

        const start = (current - 1) * ROWS_PER_PAGE;
        const end   = start + ROWS_PER_PAGE;

        // hide all, then show only the current page of filtered rows
        allRows.forEach(r => r.style.display = 'none');
        visibleRows.forEach((r, i) => {
            r.style.display = (i >= start && i < end) ? '' : 'none';
        });

        // info text
        info.textContent = visibleRows.length
            ? `Showing ${start + 1}–${Math.min(end, visibleRows.length)} of ${visibleRows.length} room${visibleRows.length !== 1 ? 's' : ''}`
            : 'No rooms found';

        // ── pagination buttons ──────────────────────────────
        // We always render MAX_BTNS slots so the row height never changes.
        // Slots that aren't needed get invisible placeholder buttons.
        const MAX_BTNS = 2 + 5; // prev + up to 5 page numbers + next = 7 slots max
        // Actually let's just build prev + pages + next and use min-width on the container.

        btns.innerHTML = '';

        const prev = document.createElement('button');
        prev.className = 'pg-btn';
        prev.textContent = '‹';
        prev.disabled = current === 1;
        prev.onclick = () => render(current - 1);
        btns.appendChild(prev);

        for (let p = 1; p <= total; p++) {
            const btn = document.createElement('button');
            btn.className = 'pg-btn' + (p === current ? ' active' : '');
            btn.textContent = p;
            btn.onclick = () => render(p);
            btns.appendChild(btn);
        }

        const next = document.createElement('button');
        next.className = 'pg-btn';
        next.textContent = '›';
        next.disabled = current === total;
        next.onclick = () => render(current + 1);
        btns.appendChild(next);
    }

    // Tab switching
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            activeFilter = tab.dataset.filter;
            render(1);
        });
    });

    render(1);
})();
</script>

<?php include '../includes/footer.php'; ?>