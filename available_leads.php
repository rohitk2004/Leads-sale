<?php
require_once 'functions.php';

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $lead_id = $_POST['lead_id'];
    add_to_cart($pdo, $lead_id);
    header("Location: cart");
    exit;
}

$available_leads = get_available_leads($pdo);
$cart_count = count(get_cart_items($pdo));

// Collect unique niches for filter
$niches = [];
foreach ($available_leads as $l) {
    $n = $l['niche'];
    if (!in_array($n, $niches))
        $niches[] = $n;
}
sort($niches);
$total_leads = count($available_leads);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Leads - QuickProject</title>
    <meta name="description" content="Browse all available premium business leads for developers">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

    <?php include 'header.php'; ?>

    <!-- Page Header -->
    <section class="pg-header">
        <div class="pg-header-bg"></div>
        <div class="container">
            <div class="pg-header-content">
                <div>
                    <h1 class="pg-title">Available Leads</h1>
                    <p class="pg-subtitle">Fresh opportunities updated daily — unlock verified client details</p>
                </div>
                <div class="pg-header-badge">
                    <span class="pg-badge-dot"></span>
                    <span><?php echo $total_leads; ?> leads available</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Leads Section -->
    <section class="pg-body">
        <div class="container">

            <!-- Filter Bar -->
            <div class="filter-bar" id="filterBar">
                <div class="filter-search">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input type="text" id="searchInput" placeholder="Search by niche, description..."
                        oninput="filterLeads()">
                </div>
                <div class="filter-group">
                    <select id="nicheFilter" onchange="filterLeads()">
                        <option value="">All Niches</option>
                        <?php foreach ($niches as $niche): ?>
                            <option value="<?php echo htmlspecialchars($niche); ?>"><?php echo htmlspecialchars($niche); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <select id="budgetFilter" onchange="filterLeads()">
                        <option value="">All Budgets</option>
                        <option value="0-10000">Under ₹10,000</option>
                        <option value="10000-25000">₹10,000 – ₹25,000</option>
                        <option value="25000-50000">₹25,000 – ₹50,000</option>
                        <option value="50000-100000">₹50,000 – ₹1,00,000</option>
                        <option value="100000-999999999">₹1,00,000+</option>
                    </select>
                </div>
                <div class="filter-group">
                    <select id="sortFilter" onchange="filterLeads()">
                        <option value="newest">Newest First</option>
                        <option value="budget-high">Budget: High → Low</option>
                        <option value="budget-low">Budget: Low → High</option>
                        <option value="price-low">Price: Low → High</option>
                    </select>
                </div>
                <button class="filter-reset" onclick="resetFilters()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="1 4 1 10 7 10" />
                        <path d="M3.51 15a9 9 0 102.13-9.36L1 10" />
                    </svg>
                    Reset
                </button>
            </div>

            <!-- Results Count -->
            <div class="filter-results" id="filterResults">
                <span>Showing <strong id="visibleCount"><?php echo $total_leads; ?></strong> of
                    <?php echo $total_leads; ?> leads</span>
            </div>

            <?php if (empty($available_leads)): ?>
                <div class="dash-empty">
                    <div class="dash-empty-icon">📭</div>
                    <h3>No leads available at the moment</h3>
                    <p>Check back soon for new opportunities!</p>
                </div>
            <?php else: ?>
                <div class="leads-grid" id="leadsGrid">
                    <?php foreach ($available_leads as $lead):
                        $phone = $lead['client_phone'];
                        $blurred_phone = str_repeat('●', max(0, strlen($phone) - 4)) . substr($phone, -4);
                        ?>
                        <div class="lead-card" data-niche="<?php echo htmlspecialchars($lead['niche']); ?>"
                            data-budget="<?php echo $lead['budget']; ?>" data-price="<?php echo $lead['lead_price']; ?>"
                            data-desc="<?php echo htmlspecialchars(strtolower($lead['description'])); ?>"
                            data-name="<?php echo htmlspecialchars(strtolower($lead['client_name'])); ?>">
                            <div class="lead-header">
                                <h3><?php echo htmlspecialchars($lead['niche']); ?></h3>
                            </div>

                            <div class="lead-details">
                                <div class="detail-row">
                                    <div class="detail-item detail-name">
                                        <span class="detail-icon">👤</span>
                                        <div class="detail-content">
                                            <span class="detail-label">Client Name</span>
                                            <span
                                                class="detail-value"><?php echo htmlspecialchars($lead['client_name']); ?></span>
                                        </div>
                                    </div>
                                    <div class="detail-item detail-phone">
                                        <span class="detail-icon">📞</span>
                                        <div class="detail-content">
                                            <span class="detail-label">Phone Number</span>
                                            <span
                                                class="detail-value blurred-text"><?php echo htmlspecialchars($blurred_phone); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-row">
                                    <div class="detail-item detail-budget">
                                        <span class="detail-icon">💰</span>
                                        <div class="detail-content">
                                            <span class="detail-label">Budget</span>
                                            <span
                                                class="detail-value text-green">₹<?php echo number_format($lead['budget']); ?>+</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-row">
                                    <div class="detail-item detail-requirement full-width">
                                        <span class="detail-icon">📋</span>
                                        <div class="detail-content">
                                            <span class="detail-label">Requirement</span>
                                            <span
                                                class="detail-value"><?php echo htmlspecialchars($lead['description']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="lead-footer">
                                <div class="price-tag">
                                    <span class="price-label">🔓 Unlock Full Details</span>
                                    <span class="price-value">₹<?php echo number_format($lead['lead_price']); ?></span>
                                </div>
                                <form method="POST">
                                    <input type="hidden" name="lead_id" value="<?php echo $lead['id']; ?>">
                                    <input type="hidden" name="add_to_cart" value="1">
                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- No Results Message -->
                <div class="filter-no-results" id="noResults" style="display:none;">
                    <div class="dash-empty">
                        <div class="dash-empty-icon">🔍</div>
                        <h3>No leads match your filters</h3>
                        <p>Try adjusting your search or filter criteria.</p>
                        <button onclick="resetFilters()" class="dash-empty-btn">Reset Filters</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script>
        function filterLeads() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const niche = document.getElementById('nicheFilter').value;
            const budget = document.getElementById('budgetFilter').value;
            const sort = document.getElementById('sortFilter').value;
            const cards = Array.from(document.querySelectorAll('#leadsGrid .lead-card'));
            let visible = 0;

            cards.forEach(card => {
                const cardNiche = card.dataset.niche;
                const cardBudget = parseInt(card.dataset.budget);
                const cardDesc = card.dataset.desc;
                const cardName = card.dataset.name;
                let show = true;

                // Search
                if (search && !cardNiche.toLowerCase().includes(search) && !cardDesc.includes(search) && !cardName.includes(search)) {
                    show = false;
                }
                // Niche filter
                if (niche && cardNiche !== niche) {
                    show = false;
                }
                // Budget filter
                if (budget) {
                    const [min, max] = budget.split('-').map(Number);
                    if (cardBudget < min || cardBudget > max) show = false;
                }

                card.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            // Sort visible cards
            const grid = document.getElementById('leadsGrid');
            const sorted = cards.filter(c => c.style.display !== 'none');
            sorted.sort((a, b) => {
                if (sort === 'budget-high') return parseInt(b.dataset.budget) - parseInt(a.dataset.budget);
                if (sort === 'budget-low') return parseInt(a.dataset.budget) - parseInt(b.dataset.budget);
                if (sort === 'price-low') return parseInt(a.dataset.price) - parseInt(b.dataset.price);
                return 0; // newest = default PHP order
            });
            sorted.forEach(card => grid.appendChild(card));

            document.getElementById('visibleCount').textContent = visible;
            document.getElementById('noResults').style.display = visible === 0 ? 'block' : 'none';
            document.getElementById('leadsGrid').style.display = visible === 0 ? 'none' : '';
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('nicheFilter').value = '';
            document.getElementById('budgetFilter').value = '';
            document.getElementById('sortFilter').value = 'newest';
            filterLeads();
        }
    </script>

</body>

</html>