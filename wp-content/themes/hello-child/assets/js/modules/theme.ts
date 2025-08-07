export function initializeTheme(): void {
  console.log('Theme initialized');
  
  // Add smooth scrolling
  setupSmoothScrolling();
  
  // Initialize responsive features
  setupResponsiveFeatures();
}

function setupSmoothScrolling(): void {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      
      const href = (this as HTMLAnchorElement).getAttribute('href');
      const target = href ? document.querySelector(href) : null;
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth'
        });
      }
    });
  });
}

function setupResponsiveFeatures(): void {
  // Add responsive utility classes based on viewport
  const updateViewportClasses = () => {
    const body = document.body;
    const width = window.innerWidth;
    
    body.classList.remove('mobile', 'tablet', 'desktop');
    
    if (width < 768) {
      body.classList.add('mobile');
    } else if (width < 1024) {
      body.classList.add('tablet');
    } else {
      body.classList.add('desktop');
    }
  };
  
  updateViewportClasses();
  window.addEventListener('resize', updateViewportClasses);
}
