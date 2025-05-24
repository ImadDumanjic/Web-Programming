let Utils = {
  datatable: function (table_id, columns, data, pageLength = 10) {
    if ($.fn.DataTable.isDataTable("#" + table_id)) {
      $("#" + table_id).DataTable().destroy();
    }

    $("#" + table_id).DataTable({
      data: data,
      columns: columns,
      pageLength: pageLength,
      lengthMenu: [5, 10, 25, 50, 100]
    });
  },

  parseJwt: function (token) {
    if (!token) return null;
    try {
      const payload = token.split('.')[1];
      return JSON.parse(atob(payload));
    } catch (e) {
      console.error("Invalid JWT token:", e);
      return null;
    }
  }
};
