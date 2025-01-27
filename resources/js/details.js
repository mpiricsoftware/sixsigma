$(function ()
{
  var dataTableform = $('.datatables-details')
  if (dataTableform.length) {
    // alert("HIIII");
    var dt_form = dataTableform.DataTable({
      processing: true,
      serverSide: false,
      ajax: {
        url: baseUrl + 'details-list'
      },

      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'id' },
        { data: 'name' },
        { data: 'description' },
        { data: 'action' }

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
          searchable: false,
          orderable: false,
          targets: 1,
          render: function (data, type, full, meta) {
            return `<span>${full.fack_id}</span>`;
          }
        },
        {
          // Name
          targets: 2,
          render: function (data, type, full, meta) {
            return `<span>${full.name}</span>`;

          }
        },
        {
          targets: 3,
          render: function (data, type, full, meta) {
            return `<span>${full.description}</span>`;
          }
        },

        {
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {

            var urls = printRoute.replace(':id', full.id);
            var chartsd = chart.replace(':id',full.id);
            return (
              '<div class="d-flex align-items-center gap-50">' +
                '<a href="' + urls + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect" title="Download">' +
                  '<i class="ri-download-line ri-20px"></i>' +
                '</a>' +
                '<a href="'+ chartsd  +'" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect" title="Download Chart">' +
                  '<i class="ri-bar-chart-box-line ri-20px"></i>' + // Changed icon for chart download
                '</a>' +
              '</div>'
            );

          }
        }
      ],
    });
  }

}
)
