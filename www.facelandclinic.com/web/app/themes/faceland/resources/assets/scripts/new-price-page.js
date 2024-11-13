$(document).ready(function () {
    function isMobileView() {
      return window.matchMedia("(max-width: 1023px)").matches;
    }
    if ($('.price-tab-menu-main li a').length > 0) {
      // Handle main tab click without fade effect
      $('.price-tab-menu-main li a').click(function (e) {
        e.preventDefault();

        // Remove active class from all main tabs
        $('.price-tab-menu-main li a').removeClass('active');
        $('.price-tab-menu-main li a').removeClass('clicked');

        // Add active class to the clicked main tab
        $(this).addClass('active');
        $(this).addClass('clicked');


        // Hide all main tab contents and remove active class
        $('.price-tab-content').removeClass('active');

        // Show the selected tab content and add active class
        var target = $(e.target).data('target');
        $(target).addClass('active');

        // Reset subcategory to 'Face' by default
        $('.price-tab-menu-sub li a').removeClass('active');
        $('.price-tab-menu-sub li a[data-sub-target="Face"]').addClass('active');

        // Hide all sub-contents and show 'Face' by default
        $(target).find('.price-tab-sub-content').removeClass('active');
        $(target).find('.price-tab-sub-content[data-sub-content="Face"]').addClass('active');

        $('.price-accordion, .treatment-lists a, .price-image-clickable').removeClass('active');
        $('.price-accordion-arrow').removeClass('rotate');
      });

      // Handle sub tab click without fade effect
      $('.price-tab-menu-sub li a').click(function (e) {
        e.preventDefault();

        // Remove active class from all sub tabs
        $('.price-tab-menu-sub li a').removeClass('active');

        // Add active class to the clicked sub tab
        $(this).addClass('active');

        // Hide all sub-contents and show the selected sub-content
        var subTarget = $(this).data('sub-target');
        $('.price-tab-content.active .price-tab-sub-content').removeClass('active');
        $('.price-tab-content.active .price-tab-sub-content[data-sub-content="' + subTarget + '"]').addClass('active');
      
        $('.price-accordion, .treatment-lists a, .price-image-clickable').removeClass('active');
        $('.price-accordion-arrow').removeClass('rotate');          
      });

      // Initialize by triggering click on the first main tab
      $('.price-tab-menu-main li a.clicked').click();
    }

    function clinicDealAAccordion() {
      if ($('.clinic-deal-body').length > 0) {
        $('.clinic-deal-body').hide();
        $('.clinic-deal').click(function () {
          // Toggle the visibility of the related combinations-body
          $(this).find('.clinic-deal-body').slideToggle();
          $(this).toggleClass("active");
          if (isMobileView()) {
            $("html, body").animate(
              {
                scrollTop:
                  $(this).offset().top - ($(".c-header").height() + 20),
              },
              "slow"
            );
          }
        });
      }
    }

    if ($('.combinations-body').length > 0) {
      $('.combinations-body').hide();
      $('.combinations-accordion').click(function () {
        // Toggle the visibility of the related combinations-body
        $(this).find('.combinations-body').slideToggle();
        $(this).toggleClass("active");
        $("html, body").animate(
          {
            scrollTop:
              $(this).offset().top - ($(".c-header").height() + 20),
          },
          "slow"
        );
      });
    }
    
    function setupPriceAccordion() {
      if ($('.price-deal-accordion').length > 0) {
        $('.price-deal-accordion').each(function () {
          const $accordionContainer = $(this); // Current accordion container
          const $accordions = $accordionContainer.find('.price-accordion');
          const accordionsPerPage = 6; // Number of accordions to show per page
          let currentPage = 1;
          const totalPages = Math.ceil($accordions.length / accordionsPerPage);
     
          // Function to generate pagination numbers
          function generatePagination() {
            const $pagination = $accordionContainer.find('.pagination');

            // Check if pagination is needed (more than 1 page)
            if (totalPages > 1) {
              $pagination.empty(); // Clear existing pagination
              for (let i = 1; i <= totalPages; i++) {
                $pagination.append(`<button class="page-number">${i}</button>`);
              }

              // Highlight the first page number initially
              $pagination.find('.page-number').eq(0).addClass('active-page');
            } else {
              // Hide or remove the pagination if there is only one page
              $pagination.hide();
              $pagination.parent().hide();
            }
          }

          // Function to show the accordions for the current page
          function showPage(page) {
            // Hide all accordions
            $accordions.hide();

            // Calculate the start and end index for the accordions to show
            const start = (page - 1) * accordionsPerPage;
            const end = start + accordionsPerPage;

            // Show the accordions for the current page
            $accordions.slice(start, end).fadeIn();

            // Update the active pagination button
            $accordionContainer.find('.page-number').removeClass('active-page');
            $accordionContainer.find('.page-number').eq(page - 1).addClass('active-page');
          }

          // Show the first page initially
          generatePagination();
          showPage(currentPage);
          // Updated js
          $accordionContainer.find('.price-accordion').each(function (index) {
            $(this).attr('data-original-index', index);
          });
          // Pagination number click handler
          // Updated js
          const $paginationBlock = $accordionContainer.find('.pagination-block');
          $accordionContainer.on('click', '.page-number', function () {
            currentPage = parseInt($(this).text()); // Get the clicked page number

            // Reset the accordions to their original order based on the stored index
            $accordionContainer.find('.price-accordion').sort(function (a, b) {
              return $(a).data('original-index') - $(b).data('original-index');
            }).appendTo($accordionContainer);

            $accordionContainer.append($paginationBlock);
            // Show the corresponding page
            showPage(currentPage);
            $('.price-accordion, .treatment-lists a, .price-image-clickable').removeClass('active');
            $('.price-accordion-arrow').removeClass('rotate');
            // Scroll back to the top of the section if not in mobile view
            if (!isMobileView()) {
              $("html, body").animate(
                {
                  scrollTop: $(".price-tab-bottom-content").offset().top - ($(".c-header").height() + 20),
                },
                "slow"
              );
            }
          });


          // Accordion toggle functionality
          // $accordionContainer.find('.price-accordion-arrow').on('click', function () {
          //   const parentAccordion = $(this).closest('.price-accordion');
          //   if (parentAccordion.hasClass('active')) {
          //     parentAccordion.removeClass('active');            
          //     $(this).removeClass('rotate');
          //   } else {
          //     $accordionContainer.find('.price-accordion').removeClass('active');
          //     $accordionContainer.find('.price-accordion-arrow').removeClass('rotate');
          //     parentAccordion.addClass('active');
          //     $(this).addClass('rotate');
          //   }
          //   if (!isMobileView()) {
          //     $("html, body").animate(
          //       {
          //         scrollTop: parentAccordion.offset().top - ($(".c-header").height() + 20),
          //       },
          //       "slow"
          //     );
          //   }
          // });
          // Click handler for the .price-accordion (only when it's closed)
          $accordionContainer.find('.price-accordion').on('click', function (event) {
              const parentAccordion = $(this).closest('.price-accordion');
              
              // If an anchor link inside the accordion is clicked, do nothing
              if (event.target.tagName === 'A') {
                return;
              }

              // Toggle 'active' class for the clicked accordion
              if (parentAccordion.hasClass('active')) {
                // If it's already active, close it by removing the 'active' class and rotating the arrow back
                parentAccordion.removeClass('active');
                $(this).find('.price-accordion-arrow').removeClass('rotate');
                
                // Remove active class from corresponding links
                const accordionId = parentAccordion.attr('id');
                $(`.price-tab-image a[href="#${accordionId}"], .treatment-lists a[href="#${accordionId}"]`).removeClass('active');
              } else {
                // Close other accordions
                $accordionContainer.find('.price-accordion').removeClass('active');
                $accordionContainer.find('.price-accordion-arrow').removeClass('rotate');
                
                // Open the clicked accordion
                parentAccordion.addClass('active');
                $(this).find('.price-accordion-arrow').addClass('rotate');
                
                // Add active class to the corresponding links
                const accordionId = parentAccordion.attr('id');
                $(`.price-tab-image a, .treatment-lists a`).removeClass('active');
                $(`.price-tab-image a[href="#${accordionId}"], .treatment-lists a[href="#${accordionId}"]`).addClass('active');
              }

            // Scroll animation only in desktop view
            if (!isMobileView()) {
              $("html, body").animate({
                scrollTop: parentAccordion.offset().top - ($(".c-header").height() + 20),
              }, "slow");
            }
          });

          $('.price-tab-image a, .treatment-lists a').on("mouseenter",function (event){
            event.preventDefault();
            let targetId = $(this).attr('href').substring(1);
            let $targetAccordion = $accordionContainer.find(`#${targetId}`);
            if ($targetAccordion.length) {
              $('.price-tab-image a, .treatment-lists a').removeClass('hover'); // Remove active class from all
              $(`.price-tab-image a[href="#${targetId}"], .treatment-lists a[href="#${targetId}"]`).addClass('hover'); // Add active class to related links
            }
          })
          $('.price-tab-image a, .treatment-lists a').on("mouseleave",function (event){
            $('.price-tab-image a, .treatment-lists a').removeClass('hover');
          })

          // Click handler for the price tab image links
          $('.price-tab-image a, .treatment-lists a').on('click', function (event) {
            event.preventDefault(); // Prevent default anchor behavior
           
            // Get the target accordion ID from the href attribute (without '#')
            let targetId = $(this).attr('href').substring(1);
             // Find all links that share the same targetId and add the active class to them
           
            let $targetAccordion = $accordionContainer.find(`#${targetId}`);

            if ($targetAccordion.length) {
              // Close any open accordion and remove the active class from all
              $('.price-tab-image a, .treatment-lists a').removeClass('active'); // Remove active class from all
              $(`.price-tab-image a[href="#${targetId}"], .treatment-lists a[href="#${targetId}"]`).addClass('active'); // Add active class to related links

              $accordionContainer.find('.price-accordion').removeClass('active'); // Remove active class
              $accordionContainer.find('.price-accordion-arrow').removeClass('rotate');

              // Open the clicked accordion and add the active class
              $targetAccordion.prependTo($accordionContainer);
              $targetAccordion.addClass('active'); // Add active class
              $targetAccordion.find('.price-accordion-arrow').addClass('rotate');

              // Calculate which page the target accordion is on
              const targetIndex = $accordions.index($targetAccordion);
              const targetPage = Math.floor(targetIndex / accordionsPerPage) + 1;

              // Show the corresponding page if it's different
              if (targetPage !== currentPage) {
                currentPage = targetPage;
                showPage(currentPage);
              }
              if (!isMobileView()) {
                // Scroll to the target accordion
                $("html, body").animate(
                  {
                    scrollTop: $targetAccordion.offset().top - ($(".c-header").height() + 20),
                  },
                  "slow"
                );
              }
            }
          });
        });
      }
    }

    function setupPriceModal() {
      if ($('.price-deal-card-box').length > 0) {
        // Create the overlay
        if (!$(".price-deal-modal-overlay").length > 0) {
          var $modalOverlay = $('<div class="price-deal-modal-overlay"></div>').appendTo('body');

          // Handle click on card links
          $('.price-deal-card-box, .price-image-clickable, .treatment-lists ul li > a').on('click', function (e) {
            e.preventDefault();

            // Close any open modals
            $('body, html').toggleClass('open-modal');
            $('.price-deal-modal').removeClass('show-modal');
            $modalOverlay.addClass('show-overly');

            // Open the targeted modal (no need for .siblings())
            var targetModal = $(this).attr('href');
            $(targetModal).addClass('show-modal'); // Correct way to show the modal
          });

          // Close modal when clicking the overlay
          $modalOverlay.on('click', function () {
            resetModal();
          });
          $(".price-deal-modal-close, .modal-back-btn").on('click', function () {
            resetModal();
          });
          function resetModal() {
            $('.price-deal-modal').removeClass('show-modal');
            $modalOverlay.removeClass('show-overly');
            $('body, html').removeClass('open-modal');
            $('.price-tab-image a, .treatment-lists a').removeClass('active');
          }
        }
      }
    }
     
    function handleView() {
      if (isMobileView()) {
        setupPriceModal();
        // Upadated JS For floting button js
        if($('.floting-btn').length > 0){
          setTimeout(() => {
            $('.floting-btn').addClass("active");
          }, 300);       
        }
      }
      // Upadated JS For floting button js
      else{
        $('.floting-btn').removeClass("active");
      }
    }
    clinicDealAAccordion();
    setupPriceAccordion();
    // Initial check
    handleView();

    // Recheck on window resize
    $(window).resize(function () {
      handleView();
    });
});