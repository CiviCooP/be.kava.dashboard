/* KAVA Search Dashlet JS */

var KavaDashboardSearchDashlet = function ($) {

    var that = this;

    this.apbFieldName = $('#kavadashboard-search-form').attr('data-apb-field-name');
    this.overnameFieldName = $('#kavadashboard-search-form').attr('data-overname-field-name');
    this.returnFields = 'id,display_name,sort_name,email,' + this.apbFieldName + ',' + this.overnameFieldName;

    this.init = function () {
        var $civicrmDashboard = $('#civicrm-dashboard');

        $civicrmDashboard.on('keyup', '#kavadashboard-search-form input', function (ev) {
            // Perform search on enter
            if (ev.keyCode == 13) {
                that.execSearch();
            }
            // Clear other field groups
            else {
                $("#kavadashboard-search-form input").not('*[data-group=' + $(this).attr('data-group') + ']').val('');
            }
        });

        $civicrmDashboard.on('submit', '#kavadashboard-search-form', function (ev) {
            that.execSearch();
        });
    };

    this.showResults = function (contacts) {
        // console.log(contacts);

        $('#kavadashboard-search-spinner').hide();
        $("#kavadashboard-search-form input").val('');

        if (contacts.length > 0) {
            var table = $('<table>');

            cj.each(contacts, function (index, contact) {
                var url = CRM.url('civicrm/contact/view', {reset: 1, cid: contact.contact_id});
                var tr = $('<tr>');
                $('<td class="kavadashboard-result-id">' + contact.contact_id + '</td>').appendTo(tr);
                $('<td class="kavadashboard-result-apb>">' + (contact[that.apbFieldName] ? contact[that.apbFieldName] + '.' + contact[that.overnameFieldName] : '') + '</td>').appendTo(tr);
                $('<td class="kavadashboard-result-name"><a href="' + url + '">' + contact.display_name + '</a></td>').appendTo(tr);
                $('<td class="kavadashboard-result-email">' + (contact.email ? '<a href="mailto:' + contact.email + '">' + contact.email + '</a>' : '') + '</td>').appendTo(tr);
                tr.appendTo(table);
            });

            $('#kavadashboard-search-results').show().html('').append(table);
        } else {
            $('#kavadashboard-search-results').show().html('<p>Geen resultaten.</p>');
        }
    };

    this.showError = function () {
        CRM.alert('An error occurred while fetching search results.');
    };

    this.getContactsFromRecords = function (records) {
        // console.log(records);

        var ids = [];
        cj.each(records, function (index, rec) {
            ids.push(rec.contact_id);
        });

        CRM.api3('Contact', 'Get', {
            contact_id: {'IN': ids},
            options: {
                sort: 'sort_name ASC'
            },
            return: that.returnFields,
            sequential: 1
        }).success(function (data) {
            that.showResults(data.values);
        }).error(function () {
            that.showError();
        });
    };

    this.execSearch = function () {

        $('#kavadashboard-search-results').hide();
        $('#kavadashboard-search-spinner').show();

        var name = $('#kavadashboard-search-name').val();
        var apb = $('#kavadashboard-search-apb').val();

        if (apb.length > 0) {

            // Get contacts by APB-nummer
            var requestOptions = {
                return: that.returnFields + ',' + that.overnameFieldName,
                options: {
                    sort: that.overnameFieldName + ' DESC, sort_name ASC'
                },
                sequential: 1
            };
            requestOptions[that.apbFieldName] = parseInt(apb);

            CRM.api3('Contact', 'Get', requestOptions)
                .success(function (data) {
                    if (data.is_error)
                        that.showError(data.error_message);
                    else
                        that.showResults(data.values);
                })
                .error(function () {
                    that.showError();
                });

        } else if (name.length > 0 && name.match(/@/)) {

            // Get email addresses, then get the associated contacts
            CRM.api3('Email', 'Get', {
                email: {'LIKE': '%' + name + '%'},
                sequential: 1
            })
                .success(function (data) {
                    if (data.is_error)
                        that.showError(data.error_message);
                    else if (data.count > 0)
                        that.getContactsFromRecords(data.values);
                    else
                        that.showResults([]);
                })
                .error(function () {
                    that.showError();
                });

        } else if (name.length > 0) {

            // Get both organisations and persons and concatenate the two result arrays
            var getByOrganizationName = CRM.api3('Contact', 'get', {
                organization_name: {'LIKE': '%' + name + '%'},
                return: that.returnFields,
                sequential: 1
            });
            var getByLastName = CRM.api3('Contact', 'get', {
                last_name: {'LIKE': '%' + name + '%'},
                return: that.returnFields,
                sequential: 1
            });

            $.when(getByOrganizationName, getByLastName)
                .done(function (data1, data2) {
                    console.log(data1, data2);
                    if (data1[0].is_error) {
                        that.showError(data1[0].error_message);
                    } else if (data2[0].is_error) {
                        that.showError(data2[0].error_message);
                    } else {
                        var data = data1[0].values
                            .concat(data2[0].values)
                            .sort(function(a, b) {
                                return a.sort_name.localeCompare(b.sort_name);
                            });
                        that.showResults(data);
                    }
                })
                .fail(function () {
                    that.showError();
                });
        } else {
            that.showError();
        }
    }

};

var kavaSearchDashlet = new KavaDashboardSearchDashlet(CRM.$);
CRM.$(function ($) {
    kavaSearchDashlet.init($);
});