$(function ()
{
  var dataTableform = $('.datatables-Inquiry')
  if (dataTableform.length) {
    // alert("HIIII");
    var dt_form = dataTableform.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'inquiry-list'
      },

      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'form_id' },
        { data: 'name' },
        { data: 'email' },
        { data: 'designation' },
        { data: 'company'},
        { data: 'form_name' },
        { data: 'date_time'},
        { data: 'designation'},
        { data: 'type'},
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
            return `<span>${full.email}</span>`;
          }
        },
        {
          targets: 4,
          render: function (data, type, full, meta) {
            return `<span>${full.Phone_no}</span>`;
          }
        },
        {
          targets: 5,
          render: function (data, type, full, meta) {
            return `<span>${full.company}</span>`;
          }
        },
        {
          targets: 6,
          render: function (data, type, full, meta)
          {
            return `<span>${full.form_name}</span>`;
          }
        },
        {
          targets: 7,
          render: function (data, type, full, meta) {
            return `<span>${full.date_time}</span>`;
          }
        },
        {
          targets: 8,
          render: function (data, type, full, meta) {
            return `<span>${full.designation}</span>`;
          }
        },
        {
          targets: 9,
          render: function (data, type, full, meta) {
            return `<span>${full.type}</span>`;
          }
        },
        {
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {

            var url = printRoute.replace(':id', full.form_id).replace(':user_id', full.user_id);


            return (
              '<div class="d-flex align-items-center gap-50">' +
              '<a href="' + url + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect" title="Download">' +
              '<i class="ri-download-line ri-20px"></i>' +
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
