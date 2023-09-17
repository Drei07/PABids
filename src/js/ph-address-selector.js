

            var my_handlers = {

                // Inside your JavaScript code
            
                // Update the fill_provinces function
                fill_provinces: function () {
                    // Get the selected region code
                    var region_code = $(this).val();
                    console.log('Selected Region Code:', region_code);
            
                    // Use the ph_locations plugin to fetch province data based on the selected region
                    $('#province').ph_locations('fetch_list', [{ "region_code": region_code }]);
                    var selectedRegionName = $('#region option:selected').text();
                    console.log('Selected Region Name:', selectedRegionName);
            
                    // Set the hidden input field with the selected region name
                    $('#region-text').val(selectedRegionName);
                },
            
                // Repeat similar updates for fill_cities and fill_barangays functions
                fill_cities: function () {
                    // Get the selected province code
                    var province_code = $(this).val();
                    console.log('Selected Province Code:', province_code);
            
                    // Use the ph_locations plugin to fetch city/municipality data based on the selected province
                    $('#city').ph_locations('fetch_list', [{ "province_code": province_code }]);
                    var selectedProvinceName = $('#province option:selected').text();
                    console.log('Selected Province Name:', selectedProvinceName);
            
                    // Set the hidden input field with the selected province name
                    $('#province-text').val(selectedProvinceName);
                },
            
                fill_barangays: function () {
                    // Get the selected city/municipality code
                    var city_code = $(this).val();
                    console.log('Selected City/Municipality Code:', city_code);
                
                    // Use the ph_locations plugin to fetch barangay data based on the selected city/municipality
                    $('#barangay').ph_locations('fetch_list', [{ "city_code": city_code }]);
                    var selectedMunicipalityName = $('#city option:selected').text();
                    console.log('Selected City/Municipality Name:', selectedMunicipalityName);
                
                    // Set the hidden input field with the selected city/municipality name
                    $('#municipality-text').val(selectedMunicipalityName);
                }                
            };

        $(function () {
            $('#region').on('change', my_handlers.fill_provinces);
            $('#province').on('change', my_handlers.fill_cities);
            $('#city').on('change', my_handlers.fill_barangays);

            $('#region').ph_locations({ 'location_type': 'regions' });
            $('#province').ph_locations({ 'location_type': 'provinces' });
            $('#city').ph_locations({ 'location_type': 'cities' });
            $('#barangay').ph_locations({ 'location_type': 'barangays' });

            $('#region').ph_locations('fetch_list');

                // Add an event handler for the barangay dropdown
    $('#barangay').on('change', function () {
        var selectedBarangayName = $(this).find('option:selected').text(); // Get the selected barangay name
        console.log('Selected Barangay Name:', selectedBarangayName);

        // Set the hidden input field with the selected barangay name
        $('#barangay-text').val(selectedBarangayName);
    });
        });