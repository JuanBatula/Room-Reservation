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
        <table>
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

</div>

<?php include '../includes/footer.php'; ?>