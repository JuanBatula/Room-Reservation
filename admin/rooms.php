<?php
include '../connect.php';
include '../includes/header.php';

$totalRooms    = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) c FROM tbroom"))['c'];
$totalAvail    = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) c FROM tbroom WHERE status='Available'"))['c'];
$totalOccupied = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) c FROM tbroom WHERE status='Occupied'"))['c'];
$totalUnavail  = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) c FROM tbroom WHERE status='Unavailable'"))['c'];

$result = mysqli_query($connection, "SELECT * FROM tbroom ORDER BY room_id ASC");
?>

<link rel="stylesheet" href="/ROOM-RESERVATION/styles/rooms.css">

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
                            onclick="return confirm('Delete \'<?php echo addslashes(htmlspecialchars($row['room_name'])); ?>\'?\nThis action cannot be undone.')">Delete</a>
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


<?php include '../includes/footer.php'; ?>

<script>
(function () {
    const ROWS_PER_PAGE = 5;

    const tbody   = document.querySelector('#roomsTable tbody');
    const allRows = Array.from(tbody.querySelectorAll('tr'));
    const info    = document.getElementById('pgInfoRooms');
    const btns    = document.getElementById('pgBtnsRooms');
    const tabs    = document.querySelectorAll('.tab-btn');

    let current      = 1;
    let activeFilter = '';

    // If naay filter gi select (ex. "Available")
    // i return ang only rows whose data-status kay mo match sa filter
    // if walay filter gi select kay: i return tanan rows
    function getFiltered() {
        if (activeFilter) {
            return allRows.filter(r => r.dataset.status === activeFilter);
        } else {
            return allRows;
        }
    }

    // so rows = 10, divided by ROWS PER PAGE(5)
    function totalPages(rows) {
        return Math.max(1, Math.ceil(rows.length / ROWS_PER_PAGE));
    }

    //shortcut ni for making the pagination buttons
    function makeBtn(label, onClick, extraClass, disabled) {
        const btn = document.createElement('button');
        let className = 'pg-btn';
        if (extraClass) {
            className += ' ' + extraClass;
        }
        btn.className = className;
        btn.textContent = label;
        if (disabled) {
            btn.disabled = true;
        }
        if (onClick) {
            btn.onclick = onClick;
        }
        return btn;
    }

    //rendering the current page --------------------------------------
    function render(page) {
        const visibleRows = getFiltered();
        const total = totalPages(visibleRows);

        current = Math.min(Math.max(page, 1), total);

        const start = (current - 1) * ROWS_PER_PAGE;
        const end   = start + ROWS_PER_PAGE;

        // DISPLAYING SA MGA ROOMS OF CURRENT PAGE
        allRows.forEach(r => r.style.display = 'none');
        visibleRows.forEach((r, i) => {
            if (i >= start && i < end) {
                r.style.display = '';  
            } else {
                r.style.display = 'none'; 
            }
        });

        // info pila ka rooms out of ----------------------
        info.textContent = visibleRows.length
        if (visibleRows.length > 0) {
            let first = start + 1;
            let last  = Math.min(end, visibleRows.length);
            let word  = visibleRows.length === 1 ? 'room' : 'rooms';
            info.textContent = `Showing ${first}–${last} of ${visibleRows.length} ${word}`;
        } else {
            info.textContent = 'No rooms found';
        }

        // pagination buttons ni ---------------------------------
        btns.innerHTML = '';
        //previous button
        btns.appendChild(makeBtn('‹', () => render(current - 1), '', current === 1));
        //number buttons
        for (let p = 1; p <= total; p++) {
            btns.appendChild(makeBtn(p, () => render(p), p === current ? 'active' : '', false));
        }
        //next button
        btns.appendChild(makeBtn('›', () => render(current + 1), '', current === total));
    }

    //filter selection listener -----------------------------------
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