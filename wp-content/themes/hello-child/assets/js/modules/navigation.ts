export function setupNavigation(): void {
  console.log('Navigation initialized');
  
  // Mobile menu toggle
  setupMobileMenu();
  
  // Dropdown menus
  setupDropdownMenus();
}

function setupMobileMenu(): void {
  const menuToggle = document.querySelector('.menu-toggle');
  const mobileMenu = document.querySelector('.mobile-menu');
  
  if (menuToggle && mobileMenu) {
    menuToggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('active');
      menuToggle.classList.toggle('active');
    });
  }
}

function setupDropdownMenus(): void {
  const dropdownMenus = document.querySelectorAll('.menu-item-has-children');
  
  dropdownMenus.forEach(menu => {
    const link = menu.querySelector('a');
    const submenu = menu.querySelector('.sub-menu');
    
    if (link && submenu) {
      // Desktop hover
      menu.addEventListener('mouseenter', () => {
        submenu.classList.add('show');
      });
      
      menu.addEventListener('mouseleave', () => {
        submenu.classList.remove('show');
      });
      
      // Mobile/touch toggle
      link.addEventListener('click', (e) => {
        if (window.innerWidth <= 768) {
          e.preventDefault();
          submenu.classList.toggle('show');
        }
      });
    }
  });
}
