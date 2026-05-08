
document.addEventListener('DOMContentLoaded', () => {
  // const headerDp = document.getElementById('header_cs');
  // const hamburger = document.getElementById('hamburger');
  // const navbar = document.getElementById('navbar');
  // const categoryDropdown =  document.getElementById('category-dropdown');
  // const body = document.body;

  // if (!hamburger) return;

  // const getActiveTarget = () => {
  //   return window.innerWidth >= 1024 ? navbar : categoryDropdown;
  // };

  // const updateIcon = (isOpen) => {
  //   const icon = hamburger.querySelector('i');
  //   if (!icon) return;

  //   icon.classList.toggle('fa-bars', !isOpen);
  //   icon.classList.toggle('fa-times', isOpen);
  // };

  // hamburger.addEventListener('click', (e) => {
  //   e.stopPropagation();

  //   const target = getActiveTarget();
  //   if (!target) return;

  //   const isOpen = target.classList.toggle('shown');

  //   body.classList.toggle('no-scroll', isOpen);
  //   updateIcon(isOpen);
  // });

  // document.addEventListener('click', (e) => {
  //   const target = getActiveTarget();
  //   if (!target) return;

  //   if (
  //     target.classList.contains('shown') &&
  //     !target.contains(e.target) &&
  //     !hamburger.contains(e.target)
  //   ) {
  //     target.classList.remove('shown');
  //     body.classList.remove('no-scroll');
  //     updateIcon(false);
  //   }
  // });

  // window.addEventListener('resize', () => {
  //   navbar?.classList.remove('shown');
  //   categoryDropdown?.classList.remove('shown');
  //   body.classList.remove('no-scroll');
  //   updateIcon(false);
  // });



 
  const headerDp = document.getElementById('header_cs');
  const hamburger = document.getElementById('hamburger');
  const navbar = document.getElementById('navbar');
  const categoryDropdown = document.getElementById('category-dropdown');
  const body = document.body;

  const updateIcon = (isOpen) => {
    const icon = hamburger?.querySelector('i');
    if (!icon) return;
    icon.classList.toggle('fa-bars', !isOpen);
    icon.classList.toggle('fa-times', isOpen);
  };

  const closeAll = () => {
    navbar?.classList.remove('shown');
    categoryDropdown?.classList.remove('shown');
    body.classList.remove('no-scroll');
    updateIcon(false);
  };

  // headerDp hover toggles navbar
  headerDp?.addEventListener('mouseenter', () => {
    navbar?.classList.add('shown');
    categoryDropdown?.classList.remove('shown');
    updateIcon(false);
  });

  headerDp?.addEventListener('mouseleave', (e) => {
    if (!navbar?.contains(e.relatedTarget)) {
      navbar?.classList.remove('shown');
    }
  });

  navbar?.addEventListener('mouseleave', (e) => {
    if (!headerDp?.contains(e.relatedTarget)) {
      navbar?.classList.remove('shown');
    }
  });

  // hamburger toggles category-dropdown
  hamburger?.addEventListener('click', (e) => {
    e.stopPropagation();
    if (!categoryDropdown) return;
    const isOpen = categoryDropdown.classList.toggle('shown');
    body.classList.toggle('no-scroll', isOpen);
    updateIcon(isOpen);
    navbar?.classList.remove('shown');
  });

  // Click outside closes category dropdown
  document.addEventListener('click', (e) => {
    if (
      categoryDropdown?.classList.contains('shown') &&
      !categoryDropdown.contains(e.target) &&
      !hamburger?.contains(e.target)
    ) {
      categoryDropdown.classList.remove('shown');
      body.classList.remove('no-scroll');
      updateIcon(false);
    }
  });

  // Clean up on resize
  window.addEventListener('resize', closeAll);

  



document.querySelectorAll('.menu-btn').forEach(button => {
  button.addEventListener('click', function (e) {
    e.stopPropagation();

    const dropdown = this.nextElementSibling;
    if (!dropdown) return;

    document.querySelectorAll('.dropdown').forEach(d => {
      if (d !== dropdown) {
        d.classList.add('hidden');
        d.classList.remove('grid');
      }
    });
    document.querySelectorAll('.megadropdown').forEach(m => {
      m.classList.remove('stay');
    });
    dropdown.classList.toggle('hidden');
    dropdown.classList.toggle('grid');
  });
});

document.addEventListener('click', () => {
  document.querySelectorAll('.dropdown').forEach(drop => {
    drop.classList.add('hidden');
    drop.classList.remove('grid');
  });

  document.querySelectorAll('.megadropdown').forEach(m => {
    m.classList.remove('stay');
  });
});


// // category filter list-------------------
// const megamenu = document.querySelectorAll('.megadown-items');

// // Open all dropdowns on page load
// document.querySelectorAll('.megadropdown').forEach(dropdown => {
//   dropdown.classList.add('stay');
// });

// megamenu.forEach(item => {
//   const dropdown = item.querySelector('.megadropdown');
//   const toggleBtn = item.querySelector('.megalink');

//   toggleBtn.addEventListener('click', function (e) {
//     e.preventDefault();
//     e.stopPropagation();

//     // Toggle only the clicked dropdown
//     dropdown.classList.toggle('stay');
//   });
// });



  const megamenuItems = document.querySelectorAll('#filterpopup .megadown-items');

  // Open all dropdowns on load
  document.querySelectorAll('#filterpopup .megadropdown').forEach(dropdown => {
    dropdown.classList.add('stay');
  });

  megamenuItems.forEach(item => {
    const dropdown = item.querySelector('#filterpopup .megadropdown');
    const toggleBtn = item.querySelector('#filterpopup .megalink');

    toggleBtn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();

      // Toggle only this dropdown
      dropdown.classList.toggle('stay');
    });
  });

  // Prevent checkbox clicks from collapsing dropdown
  document.querySelectorAll('#filterpopup .megadropdown input[type="checkbox"]').forEach(cb => {
    cb.addEventListener('click', function (e) {
      e.stopPropagation();
    });
  });

  // Prevent label click from collapsing dropdown
  document.querySelectorAll('#filterpopup .megadropdown label').forEach(label => {
    label.addEventListener('click', function (e) {
      e.stopPropagation();
    });
  });




// ✅ ADD THIS AT THE VERY END
// document.querySelectorAll('.megadropdown').forEach(drop => {
//   drop.addEventListener('click', e => {
//     e.stopPropagation();
//   });
// });

  const tabs = document.querySelectorAll('.tab-btn');
  const contents = document.querySelectorAll('.tab-item');
 if (tabs.length > 0) {
      tabs.forEach(tab => {
        tab.addEventListener('click', () => {
          const target = tab.dataset.tab;

          contents.forEach(c => c.classList.add('hidden'));

          const activePanel = document.getElementById(target);
          if (activePanel) {
            activePanel.classList.remove('hidden');
          }
        });
      });

      tabs[0].click();
    }
        const chartCtor = window.Chart;
        const wavyChart = document.getElementById('wavyChart');
        if (chartCtor && wavyChart) {
          new chartCtor(wavyChart, {
              type: 'line',
              data: {
                  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                  datasets: [{
                      label: 'My Wavy Line',
                      data: [30000, 60000, 20000, 80000, 40000, 70000, 50000],
                      borderColor: '#459B44',
                      borderWidth: 1,
                      fill: false,
                      tension: 0.5
                  }]
              },
              options: {
                  responsive: true,
                  plugins: {
                      legend: { display: false }
                  },
                  scales: {
                      y: {
                          display: true,
                          ticks: {
                              callback: function (value) {
                                  return value / 1000 + 'k';
                              }
                          },
                          grid: {
                              display: false
                          }
                      },
                      x: {
                          grid: {
                              display: false
                          }
                      }
                  }
              }
          });
        }
        const tst = document.getElementById('myChart');
        if (chartCtor && tst) {
          new chartCtor(tst, {
            type: 'bar',
            data: {
              labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
              datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                borderWidth: 1
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        }
        });
        

        /* ---------------------------------------------------
   DASHBOARD NAV (dashboard sidebar hamburger)
---------------------------------------------------- */
document.addEventListener("DOMContentLoaded", () => {
  const dashboardbar = document.getElementById('dashboardhamburger');
  const dashboardnav = document.getElementById('dashboardnav-wrapper');
  const page = document.body;

  // Only proceed if both elements exist
  if (!dashboardbar || !dashboardnav) return;

  // Toggle dashboard nav on click
  dashboardbar.addEventListener('click', (e) => {
    e.stopPropagation(); // Prevent the document click from immediately closing it
    dashboardnav.classList.toggle('show');
    page.classList.toggle('no-scroll');

    const icon = dashboardbar.querySelector('i');
    if (dashboardnav.classList.contains('show')) {
      icon.classList.remove('fa-bars');
      icon.classList.add('fa-times');
    } else {
      icon.classList.remove('fa-times');
      icon.classList.add('fa-bars');
    }
  });

  // Close dashboard nav when clicking outside
  document.addEventListener('click', (e) => {
    if (!dashboardnav.classList.contains('show')) return; // Already closed, do nothing

    if (!dashboardnav.contains(e.target) && !dashboardbar.contains(e.target)) {
      dashboardnav.classList.remove('show');
      page.classList.remove('no-scroll');

      const icon = dashboardbar.querySelector('i');
      if (icon) { // Safety check
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
      }
    }
  });
});


// const drop = document.getElementById('category-btn');
// const dropshow = document.getElementById('category-dropdown');
// const body = document.body;
// if (drop && dropshow) { 
// drop.addEventListener('click', (e) => {
//   e.stopPropagation();

//   dropshow.classList.toggle('shown');
//   body.classList.toggle('no-scroll');

//   const icon = drop.querySelector('i');
//   if (dropshow.classList.contains('shown')) {
//     icon.classList.remove('fa-bars');
//     icon.classList.add('fa-times');
//   } else {
//     icon.classList.remove('fa-times');
//     icon.classList.add('fa-bars');
//   }

// });
// }

// document.addEventListener('click', (e) => {
//   if (!dropshow || !drop) return; 
//   if (dropshow.classList.contains('shown') &&
//     !dropshow.contains(e.target) &&
//     drop.contains(e.target)) {

//     dropshow.classList.remove('shown');
//     body.classList.remove('no-scroll');

//     const icon = drop.querySelector('i');
//     icon.classList.remove('fa-times');
//     icon.classList.add('fa-bars');
//   }
// });

document.addEventListener("DOMContentLoaded", () => {

    const popup = document.getElementById("filterpopup");
    const openBtn = document.getElementById("filterbtn");
    if (!popup || !openBtn) return;
    const closeBtn = popup.querySelector(".close");
    const html = document.documentElement;
    // OPEN popup
    openBtn.addEventListener("click", () => {
        popup.classList.toggle("active");
       html.classList.toggle("no-scroll");
    });
 if (closeBtn) {
    closeBtn.addEventListener("click", (e) => {
      popup.classList.remove("active");
      html.classList.remove("no-scroll");
    });
  }

});

document.addEventListener("DOMContentLoaded", () => {
  const drop = document.getElementById("category-btn");
  const dropdown = document.getElementById("category-dropdown");
  const body = document.body;

  if (!drop || !dropdown) return;

  const icon = drop.querySelector("i");
  const canHover = window.matchMedia("(hover: hover)").matches;
  let closeTimer;

  function openMenu() {
    dropdown.classList.add("shown");
    body.classList.add("no-scroll");
    icon?.classList.replace("fa-bars", "fa-times");
  }

  function closeMenu() {
    dropdown.classList.remove("shown");
    body.classList.remove("no-scroll");
    icon?.classList.replace("fa-times", "fa-bars");
  }

  /* -------------------------
     DESKTOP — HOVER
  -------------------------- */
  if (canHover) {
    drop.addEventListener("mouseenter", () => {
      clearTimeout(closeTimer);
      openMenu();
    });

    dropdown.addEventListener("mouseenter", () => {
      clearTimeout(closeTimer);
    });

    drop.addEventListener("mouseleave", () => {
      closeTimer = setTimeout(closeMenu, 150);
    });

    dropdown.addEventListener("mouseleave", () => {
      closeTimer = setTimeout(closeMenu, 150);
    });
  }

  /* -------------------------
     MOBILE — CLICK
  -------------------------- */
  drop.addEventListener("click", (e) => {
    e.preventDefault();
    e.stopPropagation();

    dropdown.classList.contains("shown") ? closeMenu() : openMenu();
  });

  /* -------------------------
     CLICK OUTSIDE TO CLOSE
  -------------------------- */
  document.addEventListener("click", (e) => {
    if (
      dropdown.classList.contains("shown") &&
      !dropdown.contains(e.target) &&
      !drop.contains(e.target)
    ) {
      closeMenu();
    }
  });
});
document.querySelectorAll('.all-categories').forEach(menu => {
  const tabs = menu.querySelectorAll('[role="tab"]');
  const panels = menu.querySelectorAll('[role="tabpanel"]');
  const content = menu.querySelector('.category-content');
const underline = menu.querySelector('.tab-underline');

  function moveUnderline(tab) {
    if (!underline) return;

    const tabRect = tab.getBoundingClientRect();
    const parentRect = tab.parentElement.getBoundingClientRect();

    underline.style.width = `${tabRect.width}px`;
    underline.style.transform =
      `translateX(${tabRect.left - parentRect.left}px)`;
  }

  function activateTab(tab) {
    const panelId = tab.getAttribute('aria-controls');

    tabs.forEach(t => {
      t.setAttribute('aria-selected', 'false');
      t.setAttribute('tabindex', '-1');
    });

    panels.forEach(p => p.hidden = true);

    tab.setAttribute('aria-selected', 'true');
    tab.setAttribute('tabindex', '0');
    document.getElementById(panelId).hidden = false;

    content.classList.add('active');
     moveUnderline(tab);
  }

  tabs.forEach(tab => {
    tab.addEventListener('mouseenter', () => {
      if (window.innerWidth > 768) activateTab(tab);
    });

    tab.addEventListener('click', e => {
      if (window.innerWidth <= 768) {
        e.stopPropagation();
        activateTab(tab);
      }
    });

    tab.addEventListener('keydown', e => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        activateTab(tab);
      }
    });
  });

  menu.addEventListener('mouseleave', () => {
    if (window.innerWidth > 768) {
      content.classList.remove('active');
      panels.forEach(p => p.hidden = true);
      tabs.forEach(t => t.setAttribute('aria-selected', 'false'));
         if (underline) underline.style.width = '0';
    }
  });

  document.addEventListener('click', e => {
    if (window.innerWidth <= 768 && !menu.contains(e.target)) {
      content.classList.remove('active');
      panels.forEach(p => p.hidden = true);
      tabs.forEach(t => t.setAttribute('aria-selected', 'false'));
         if (underline) underline.style.width = '0';
    }
  });
});

// document.querySelectorAll('.vertical-tabs').forEach(menu => {
//   const menuId = menu.id || `tabs-${Math.random().toString(36).slice(2)}`;
//   const tabs = menu.querySelectorAll('[role="tab"]');
//   const panels = menu.querySelectorAll('[role="tabpanel"]');

//   // 🔹 Generate ARIA ids dynamically
//   tabs.forEach((tab, index) => {
//     const key = tab.dataset.tab || `tab-${index}`;
//     const panel = menu.querySelector(`[data-tab-panel="${key}"]`);

//     const tabId = `${menuId}-${key}-tab`;
//     const panelId = `${menuId}-${key}-panel`;

//     tab.id = tabId;
//     tab.setAttribute('aria-controls', panelId);
//     tab.setAttribute('aria-selected', 'false');
//     tab.setAttribute('tabindex', '-1');

//     if (panel) {
//       panel.id = panelId;
//       panel.setAttribute('aria-labelledby', tabId);
//       panel.hidden = true;
//     }
//   });

//   // 🔹 Activate tab
//   function activateTab(tab) {
//     const panelId = tab.getAttribute('aria-controls');

//     tabs.forEach(t => {
//       t.setAttribute('aria-selected', 'false');
//       t.setAttribute('tabindex', '-1');
//     });

//     panels.forEach(p => p.hidden = true);

//     tab.setAttribute('aria-selected', 'true');
//     tab.setAttribute('tabindex', '0');

//     const panel = menu.querySelector(`#${panelId}`);
//     if (panel) panel.hidden = false;
//   }

//   // ✅ OPEN FIRST TAB ON PAGE LOAD
//   if (tabs.length) {
//     activateTab(tabs[0]);
//   }

//   // 🔹 Events
//   tabs.forEach(tab => {
//     tab.addEventListener('mouseenter', () => {
//       if (window.innerWidth >= 1024) {
//         activateTab(tab);
//       }
//     });

//     tab.addEventListener('click', e => {
//       if (window.innerWidth < 1024) {
//         e.preventDefault();
//         activateTab(tab);
//       }
//     });

//     tab.addEventListener('keydown', e => {
//       if (e.key === 'Enter' || e.key === ' ') {
//         e.preventDefault();
//         activateTab(tab);
//       }
//     });
//   });

//   // Optional: close on mouse leave (desktop)
//   menu.addEventListener('mouseleave', () => {
//     if (window.innerWidth >= 1024) {
//       tabs.forEach(t => t.setAttribute('aria-selected', 'false'));
//       panels.forEach(p => p.hidden = true);

//       // 👇 keep first tab open even after mouse leave (optional)
//       activateTab(tabs[0]);
//     }
//   });
// });


document.querySelectorAll('.vertical-tabs').forEach(menu => {
  const menuId = menu.id || `tabs-${Math.random().toString(36).slice(2)}`;
  const tabs = menu.querySelectorAll('[role="tab"]');
  const panels = menu.querySelectorAll('[role="tabpanel"]');
  const tabContent = menu.querySelector('.tab-content');

  // 🔹 Generate ARIA ids dynamically
  tabs.forEach((tab, index) => {
    const key = tab.dataset.tab || `tab-${index}`;
    const panel = menu.querySelector(`[data-tab-panel="${key}"]`);

    const tabId = `${menuId}-${key}-tab`;
    const panelId = `${menuId}-${key}-panel`;

    tab.id = tabId;
    tab.setAttribute('aria-controls', panelId);
    tab.setAttribute('aria-selected', 'false');
    tab.setAttribute('tabindex', '-1');

    if (panel) {
      panel.id = panelId;
      panel.setAttribute('aria-labelledby', tabId);
      panel.hidden = true;
    }
  });

  function activateTab(tab) {
    const panelId = tab.getAttribute('aria-controls');

    tabs.forEach(t => {
      t.setAttribute('aria-selected', 'false');
      t.setAttribute('tabindex', '-1');
    });

    panels.forEach(p => (p.hidden = true));

    tab.setAttribute('aria-selected', 'true');
    tab.setAttribute('tabindex', '0');

    const panel = menu.querySelector(`#${panelId}`);
    if (panel) panel.hidden = false;

    // 🔥 MOBILE: slide panel in
    if (window.innerWidth < 1024) {
      menu.classList.add('mobile-panel-open');
    }
  }

  // ✅ OPEN FIRST TAB ON DESKTOP
  if (tabs.length && window.innerWidth >= 1024) {
    activateTab(tabs[0]);
  }

  // 🔹 Tab events
  tabs.forEach(tab => {
    tab.addEventListener('mouseenter', () => {
      if (window.innerWidth >= 1024) {
        activateTab(tab);
      }
    });

    tab.addEventListener('click', e => {
      if (window.innerWidth < 1024) {
        e.preventDefault();
        activateTab(tab);
      }
    });

    tab.addEventListener('keydown', e => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        activateTab(tab);
      }
    });
  });

  // 🔙 Back buttons (mobile)
  panels.forEach(panel => {
    const backBtn = panel.querySelector('.panel-back');
    if (!backBtn) return;

    backBtn.addEventListener('click', () => {
      menu.classList.remove('mobile-panel-open');
      panels.forEach(p => (p.hidden = true));
      tabs.forEach(t => t.setAttribute('aria-selected', 'false'));
    });
  });

  // Desktop mouse leave (optional)
  menu.addEventListener('mouseleave', () => {
    if (window.innerWidth >= 1024 && tabs.length) {
      activateTab(tabs[0]);
    }
  });
});
