$(function ()
{
  var dataTableform = $('.datatables-Inquiry')
  if (dataTableform.length) {
    // alert("HIIII");
    var dt_form = dataTableform.DataTable({
      processing: true,
      serverSide: false,
      ajax: {
        url: baseUrl + 'inquiry-list'
      },

      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'id' },
        { data: 'name' },
        { data: 'email' },
        { data: 'designation' },
        { data: 'company'},
        { data: 'date_time'},
        { data: 'designation'},
        { data: 'type'},

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
            return `<span>${full.id}</span>`;
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
          render: function (data, type, full, meta) {
            return `<span>${full.date_time}</span>`;
          }
        },
        {
          targets: 7,
          render: function (data, type, full, meta) {
            return `<span>${full.designation}</span>`;
          }
        },
        {
          targets: 8,
          render: function (data, type, full, meta) {
            return `<span>${full.type}</span>`;
          }
        },

      ],
    });
  }

}
)
