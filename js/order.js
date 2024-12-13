$(document).ready(function () {
      // Add event listener to the "Make Invoice" button
      $('#order_form').click(function () {
          // Collect order data from the form
          const data = {
              order_date: $('#order_date').val(),
              cust_name: $('#cust_name').val(),
              sub_total: $('#sub_total').val(),
              gst: $('#gst').val(),
              discount: $('#discount').val(),
              net_total: $('#net_total').val(),
              paid: $('#paid').val(),
              due: $('#due').val(),
              payment_type: $('#payment_type').val(),
          };
  
          // Send the data to the server to create the invoice
          sendInvoiceData(data);
      });
  
      // Handle the Print Invoice button click
      $('#print_invoice').click(function () {
          // Ensure the button is visible and not hidden
          if (!$(this).hasClass('hidden')) {
              window.print();  // Trigger the print dialog
          } else {
              console.log('Print button is hidden. Cannot trigger print.');
          }
      });
  
      function sendInvoiceData(data) {
          fetch('process_invoice.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
              },
              body: JSON.stringify(data),
          })
          .then((response) => {
              if (!response.ok) {
                  throw new Error(`HTTP error! Status: ${response.status}`);
              }
              return response.json();  // Parse the response
          })
          .then((result) => {
              if (result.success) {
                  alert('Invoice created successfully!');
                  $('#print_invoice').removeClass('hidden');
              } else {
                  alert('Failed to create invoice. Please try again.');
              }
          })
          .catch((error) => {
              console.error('Error:', error);
              alert('An error occurred while processing your request. Please try again.');
          });
      }
  
      // Add new row when the 'add' button is clicked
      $('#add').click(function () {
          addNewRow();
      });
  
      function addNewRow() {
          $.ajax({
              url: './inc/process.php',
              method: 'POST',
              data: { getNewOrderItem: 1 },
              success: function (data) {
                  $('#invoice_item').append(data);
                  updateRowNumbers();
              },
          });
      }
  
      // Update row numbers when a new row is added
      function updateRowNumbers() {
          var n = 0;
          $('.number').each(function () {
              $(this).html(++n);  // Update number in each row
          });
      }
  
      // Remove the last row when the 'remove' button is clicked
      $('#remove').click(function () {
          var lastRow = $('#invoice_item').children('tr:last');
          if (lastRow.length > 0) {
              lastRow.remove();
              calculate(0, 0);
          }
      });
  
      // Handle changes in product dropdown (with event delegation for dynamically added rows)
      $('#invoice_item').on('change', '.pid', function () {
          var pid = $(this).val();
          var tr = $(this).closest('tr');  // Find the parent row
          $.ajax({
              url: './inc/process.php',
              method: 'POST',
              dataType: 'json',
              data: { getPriceAndQty: 1, id: pid },
              success: function (data) {
                  // Populate the row with data from the response
                  tr.find('.tqty').val(data['quantity']);
                  tr.find('.pro_name').val(data['productname']);
                  tr.find('.qty').val(1);
                  tr.find('.price').val(data['price']);
                  tr.find('.amt').html(tr.find('.qty').val() * tr.find('.price').val());
                  calculate(0, 0);
              },
          });
      });
  
      // Handle form submission to save the invoice using jQuery AJAX
      $('#order_form').click(function (event) {
          event.preventDefault();  // Prevent default form submission
          var formData = new FormData($('#get_order_data')[0]);  // Collect form data
  
          $.ajax({
              type: 'POST',
              url: 'save_invoice.php',
              data: formData,
              contentType: false,  // This tells jQuery not to set a content type
              processData: false,  // This tells jQuery not to process the data
              success: function (response) {
                  console.log(response);  // Handle success
                  alert('Invoice saved successfully!');
              },
              error: function (xhr, status, error) {
                  console.log('AJAX Error: ' + error);  // Handle error
                  alert('An error occurred while saving the invoice.');
              },
          });
      });
  });
  