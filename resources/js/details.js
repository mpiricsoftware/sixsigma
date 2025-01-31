$(function () {
  var dataTableform = $('.datatables-details');
  if (dataTableform.length) {
    var dt_form = dataTableform.DataTable({
      processing: true,
      serverSide: false,
      ajax: {
        url: baseUrl + 'details-list'
      },
      columns: [
        { data: '' }, // For Responsive column
        { data: 'id' }, // Form ID
        { data: 'user_name' }, // User name
        { data: 'user_email' }, // User email
        { data: 'form_name' }, // Form name
        { data: 'form_description' },
        { data: 'action' }, // Action buttons

      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return '';
          }
        },
        {
          // Fake ID
          searchable: false,
          orderable: false,
          targets: 1,
          render: function (data, type, full, meta) {
            return `<span>${full.fack_id}</span>`;
          }
        },
        {
          // User Name
          targets: 2,
          render: function (data, type, full, meta) {
            return `<span>${full.user_name || 'N/A'}</span>`; // Default to 'N/A' if user_name is null
          }
        },
        {
          // User Email
          targets: 3,
          render: function (data, type, full, meta) {
            return `<span>${full.user_email || 'N/A'}</span>`; // Default to 'N/A' if user_email is null
          }
        },
        {
          // Form Name
          targets: 4,
          render: function (data, type, full, meta) {
            return `<span>${full.form_name}</span>`;
          }
        },
        {
          // Form Description
          targets: 5,
          render: function (data, type, full, meta) {
            return `<span>${full.form_description}</span>`;
          }
        },


        {
          // Action Buttons
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            var urls = printRoute.replace(':id', full.form_id).replace(':user_id', full.user_id);
            var chartsd = chart.replace(':id', full.form_id);
            return (
              '<div class="d-flex align-items-center gap-50">' +
                '<a href="' + urls + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect" title="Download">' +
                  '<i class="ri-download-line ri-20px"></i>' +
                '</a>' +
                '<a href="' + chartsd + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect" title="Download Chart">' +
                  '<i class="ri-bar-chart-box-line ri-20px"></i>' +
                '</a>' +
              '</div>'
            );
          }
        }
      ],
    });
  }
});
