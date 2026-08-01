<?php
// Calculate cart count for the badge
$cart_count = 0;
if (isset($pdo)) {
    $cart_count = count(get_cart_items($pdo));
}

// Helper function for relative paths depending on directory depth
$base_path = (strpos($_SERVER['SCRIPT_NAME'], '/industries/') !== false || strpos($_SERVER['SCRIPT_NAME'], '/services/') !== false || strpos($_SERVER['SCRIPT_NAME'], '/tools/') !== false || strpos($_SERVER['SCRIPT_NAME'], '/forum/') !== false) ? '../' : '';
?>
<!-- Tailwind CSS CDN & Font Config from BlackHatSEO Course -->
<script src="https://cdn.tailwindcss.com?plugins=typography"></script>
<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
            mono: ['JetBrains Mono', 'monospace'],
            display: ['Outfit', 'sans-serif'],
          }
        }
      }
    }
</script>

<!-- Noise Texture Layer -->
<div class="noise-overlay"></div>

<!-- Top Announcement Bar -->
<div class="top-announcement-bar">
    <div class="container">
        <div class="top-announcement-content">
            <span class="top-announcement-badge">🚨 FINAL WAKE-UP CALL</span>
            <span>Learn Advanced Call-Generation & Survival SEO in 30 Days</span>
            <a href="<?php echo $base_path; ?>available_leads.php" style="color: #ff6b35; font-weight: 700; text-decoration: underline; margin-left: 8px;">Enroll Now &rarr;</a>
        </div>
    </div>
</div>

<!-- ============ EXACT NAV FROM BLACKHATSEOCOURSE.COM ============ -->
<header class="floating-pill sticky top-0 z-50 py-5 bg-[#08090d]/95 backdrop-blur-xl border-b border-white/10">
  <div class="max-w-[1400px] mx-auto px-8 flex items-center justify-between">
    
    <!-- LOGO (Left) -->
    <a href="<?php echo $base_path; ?>index.php" class="flex items-center gap-2.5 hover:opacity-85 transition text-decoration-none">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" class="text-amber-500"><path d="M13 10V3L4 14h7v7l9-11h-7z" fill="currentColor"/></svg>
      <span class="font-display font-bold text-2xl tracking-tight text-white">BlackHat<span class="text-[#00f2fe] ml-1">SEO</span></span>
    </a>

    <!-- Navigation Links (Middle - Exact Order) -->
    <nav class="hidden md:flex items-center gap-6 font-display text-sm font-semibold uppercase tracking-wider text-white">
      <a href="<?php echo $base_path; ?>forum/index.php" class="hover:text-[#00f2fe] transition nav-link-effect py-2">Forum</a>
      <a href="<?php echo $base_path; ?>tools/index.php" class="hover:text-[#00f2fe] transition nav-link-effect py-2">Tools</a>
      
      <!-- Industries Dropdown (Mega Menu) -->
      <div class="relative group">
        <a href="<?php echo $base_path; ?>industries/index.php" class="hover:text-[#00f2fe] transition nav-link-effect flex items-center gap-1 py-2 focus:outline-none uppercase font-display text-sm font-semibold tracking-wider text-white">
          Industries
          <svg class="w-3 h-3 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
        </a>
        
        <div class="absolute left-1/2 -translate-x-1/2 top-full pt-4 w-[750px] opacity-0 translate-y-3 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-300 z-50">
          <div class="bg-[#090a0f] border border-white/10 rounded-2xl p-6 shadow-2xl grid grid-cols-4 gap-2 backdrop-blur-xl">
            <a href="<?php echo $base_path; ?>industries/airlines.php" class="mega-menu-link">Airlines</a>
            <a href="<?php echo $base_path; ?>industries/travel.php" class="mega-menu-link">Travel</a>
            <a href="<?php echo $base_path; ?>industries/tech-support.php" class="mega-menu-link">Tech Support</a>
            <a href="<?php echo $base_path; ?>industries/saas.php" class="mega-menu-link">SaaS</a>
            <a href="<?php echo $base_path; ?>industries/ecommerce.php" class="mega-menu-link">E-commerce</a>
            <a href="<?php echo $base_path; ?>industries/finance.php" class="mega-menu-link">Finance</a>
            <a href="<?php echo $base_path; ?>industries/insurance.php" class="mega-menu-link">Insurance</a>
            <a href="<?php echo $base_path; ?>industries/healthcare.php" class="mega-menu-link">Healthcare</a>
            <a href="<?php echo $base_path; ?>industries/real-estate.php" class="mega-menu-link">Real Estate</a>
            <a href="<?php echo $base_path; ?>industries/legal.php" class="mega-menu-link">Legal</a>
            <a href="<?php echo $base_path; ?>industries/education.php" class="mega-menu-link">Education</a>
            <a href="<?php echo $base_path; ?>industries/home-services.php" class="mega-menu-link">Home Services</a>
            <a href="<?php echo $base_path; ?>industries/gaming.php" class="mega-menu-link">Gaming</a>
            <a href="<?php echo $base_path; ?>industries/cryptocurrency.php" class="mega-menu-link">Cryptocurrency</a>
            <a href="<?php echo $base_path; ?>industries/automotive.php" class="mega-menu-link">Automotive</a>
            <a href="<?php echo $base_path; ?>industries/accounting.php" class="mega-menu-link">QuickBooks & Accounting</a>
          </div>
        </div>
      </div>

      <!-- Services Dropdown (Mega Menu) -->
      <div class="relative group">
        <a href="<?php echo $base_path; ?>services/index.php" class="hover:text-[#00f2fe] transition nav-link-effect flex items-center gap-1 py-2 focus:outline-none uppercase font-display text-sm font-semibold tracking-wider text-white">
          Services
          <svg class="w-3 h-3 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
        </a>
        
        <div class="absolute left-1/2 -translate-x-1/2 top-full pt-4 w-[600px] opacity-0 translate-y-3 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-300 z-50">
          <div class="bg-[#090a0f] border border-white/10 rounded-2xl p-6 shadow-2xl grid grid-cols-2 gap-3 backdrop-blur-xl">
            <a href="<?php echo $base_path; ?>services/black-hat-seo.php" class="mega-menu-link">Black Hat SEO</a>
            <a href="<?php echo $base_path; ?>services/grey-hat-seo.php" class="mega-menu-link">Grey Hat SEO</a>
            <a href="<?php echo $base_path; ?>services/high-velocity-indexing.php" class="mega-menu-link">High-Velocity Indexing</a>
            <a href="<?php echo $base_path; ?>services/ctr-manipulation.php" class="mega-menu-link">CTR SERP Bot</a>
            <a href="<?php echo $base_path; ?>services/pbn-network-setup.php" class="mega-menu-link">PBN Network Setup</a>
            <a href="<?php echo $base_path; ?>services/parasite-seo.php" class="mega-menu-link">Parasite SEO</a>
            <a href="<?php echo $base_path; ?>services/cloaking.php" class="mega-menu-link">Technical Cloaking</a>
            <a href="<?php echo $base_path; ?>services/negative-seo-protection.php" class="mega-menu-link">Negative SEO Protection</a>
          </div>
        </div>
      </div>

      <a href="<?php echo $base_path; ?>available_leads.php" class="hover:text-[#00f2fe] transition nav-link-effect py-2">Courses</a>
      <a href="<?php echo $base_path; ?>contact.php" class="hover:text-[#00f2fe] transition nav-link-effect py-2">Contact Us</a>
    </nav>

    <!-- Phone Action & Cart (Right) -->
    <div class="flex items-center gap-3">
      <a href="tel:+918920624649" class="hidden lg:flex items-center gap-2 px-4 py-2 rounded-full border border-[#00f2fe]/40 bg-[#00f2fe]/5 text-[#00f2fe] font-mono text-xs font-bold hover:bg-[#00f2fe]/15 transition">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        <span>+91 (892) 062-4649</span>
      </a>

      <a href="<?php echo $base_path; ?>cart.php" class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl border border-white/10 bg-white/5 text-white font-display text-xs font-semibold hover:border-[#00f2fe] hover:text-[#00f2fe] transition">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <span>Cart</span>
        <?php if ($cart_count > 0): ?>
          <span class="bg-[#ff5722] text-white font-mono text-[10px] font-extrabold px-1.5 py-0.5 rounded-full"><?php echo $cart_count; ?></span>
        <?php endif; ?>
      </a>

      <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="<?php echo $base_path; ?>register.php" class="px-4 py-2 rounded-xl bg-gradient-to-r from-[#00f2fe] to-[#00b4d8] text-black font-display font-bold text-xs shadow-[0_4px_14px_rgba(0,242,254,0.3)] hover:scale-105 transition">
          Join Course
        </a>
      <?php endif; ?>
    </div>

  </div>
</header>