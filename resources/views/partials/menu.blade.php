<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" data-bg-class="bg-menu-theme">
    <!-- Brand Section -->
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold ms-2">Ultra Stones</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <!-- Shadow Effect -->
    <div class="menu-inner-shadow"></div>

    <!-- Menu Items -->
    <ul class="menu-inner py-1 ps ps--active-y">
        <!-- Dashboards -->
        <li class="menu-item {{ request()->is('home') ? 'active open' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>

        <!-- System Setting -->
        <li class="menu-item {{ request()->is('companies')||request()->is('states*') || request()->is('bin_types*') || request()->is('file_types*') || request()->is('transaction_startings*') || request()->is('currencies*') || request()->is('select_type_categories*') ||request()->is('select_type_sub_categories*') ||request()->is('print_doc_disclaimers*') ||request()->is('departments*')|| request()->is('designations*') ||request()->is('product_types*') ||request()->is('product_price_ranges*')|| request()->is('product_categories*') || request()->is('product_groups*') || request()->is('product_colors*') || request()->is('product_finishes*') || request()->is('pick_ticket_restrictions*') || request()->is('countries*') ||request()->is('price_list_labels')|| request()->is('project_types*') || request()->is('sub_headings*')||request()->is('calculate_measurement_labels*')||request()->is('event_types*')||request()->is('opportunity_stages*')||request()->is('probability_to_closes*')||request()->is('release_reason_codes*')|| request()->is('inventory_adjustment_reason_codes*')|| request()->is('adjustment_types*')||  request()->is('end_use_segments*')||request()->is('about_us_options*')||request()->is('product_thicknesses*')||request()->is('customer_types*') || request()->is('shipment_methods*')||request()->is('customer_contact_titles*')||request()->is('unit_measures*')||request()->is('survey_questions')||request()->is('credit_check_settings')||request()->is('return_reason_codes')||request()->is('supplier_types')||request()->is('vendor_types')||request()->is('shipment_terms') ||request()->is('supplier_ports')||request()->is('supplier_return_statuses')||request()->is('purchase_shipment_methods')||request()->is('supplier_cost_list_labels')|| request()->is('receiving_qc_notes')|| request()->is('default_link_accounts')|| request()->is('expense_categories')|| request()->is('account_payment_terms')|| request()->is('payment_methods')|| request()->is('account_receivable_aging_periods')|| request()->is('aging_periods_aps') || request()->is('linked_accounts')|| request()->is('account_types')||request()->is('account_sub_types')||request()->is('tax_exempt_reasons') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="bx bx-cog menu-icon"></i>
                <div class="text-truncate" data-i18n="System Setting">System Setting</div>
            </a>

            <ul class="menu-sub">
                <!-- Company -->
                <li class="menu-item {{ request()->is('companies')||request()->is('states*') || request()->is('bin_types*') || request()->is('file_types*') || request()->is('select_type_categories*') || request()->is('select_type_sub_categories*') || request()->is('print_doc_disclaimers*') || request()->is('transaction_startings*') || request()->is('currencies*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div class="text-truncate" data-i18n="Company">Company</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->is('companies') ? 'active' : '' }}">
                            <a href="{{ route('companies.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Company Profile">Company Profile</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('states') ? 'active' : '' }}">
                            <a href="{{ route('states.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="States">States</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('bin_types') ? 'active' : '' }}">
                            <a href="{{ route('bin_types.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Bin Types">Bin Types</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('file_types') ? 'active' : '' }}">
                            <a href="{{ route('file_types.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="File Types">File Types</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('transaction_startings') ? 'active' : '' }}">
                            <a href="{{ route('transaction_startings.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Transaction Starting Numbers" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary" title="Transaction Starting Numbers">Transaction Starting Numbers</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('currencies') ? 'active' : '' }}">
                            <a href="{{ route('currencies.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Currencies">Currencies</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('select_type_categories') ? 'active' : '' }}">
                            <a href="{{ route('select_type_categories.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Select Type Category">Select Type Category</div>
                            </a>
                        </li>

                        <li class="menu-item {{ request()->is('select_type_sub_categories') ? 'active' : '' }}">
                            <a href="{{ route('select_type_sub_categories.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Select Type Sub Category" data-bs-toggle="tooltip"
                                    data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary"
                                    title="Select Type Sub Category">Select Type Sub Category</div>
                            </a>
                        </li>

                        <li class="menu-item {{ request()->is('print_doc_disclaimers') ? 'active' : '' }}">
                            <a href="{{ route('print_doc_disclaimers.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Print Doc Disclaimers">Print Doc Disclaimers</div>
                            </a>
                        </li>
                    </ul>
                </li>



                <!-- User -->
                <li class="menu-item {{ request()->is('departments*')||request()->is('designations*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div class="text-truncate" data-i18n="User">User</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->is('departments') ? 'active open' : '' }}">
                            <a href="{{ route('departments.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Department">Department</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('designations') ? 'active open' : '' }}">
                            <a href="{{ route('designations.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Designation">Designation</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Products/Inventory -->
                <li class="menu-item {{ request()->is('unit_measures*') ||request()->is('product_types*') || request()->is('product_categories*') || request()->is('product_price_ranges*') || request()->is('product_groups*') || request()->is('product_colors*') || request()->is('pick_ticket_restrictions*')|| request()->is('product_finishes*') || request()->is('countries*') || request()->is('product_thicknesses*') || request()->is('inventory_adjustment_reason_codes*')|| request()->is('adjustment_types*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div class="text-truncate" data-i18n="Products/Inventory">Products/Inventory</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->is('unit_measures*') ? 'active open' : '' }}">
                            <a href="{{ route('unit_measures.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Units of Measure">Units of Measure </div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('product_types*') ? 'active open' : '' }}">
                            <a href="{{ route('product_types.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Product Type">Product Type</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('product_categories*') ? 'active open' : '' }}">
                            <a href="{{ route('product_categories.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Product Category">Product Category</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('product_groups*') ? 'active open' : '' }}">
                            <a href="{{ route('product_groups.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Product Groups">Product Groups</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('product_price_ranges*') ? 'active open' : '' }}">

                        <li class="menu-item {{ request()->is('product_price_ranges') ? 'active open' : '' }}">
                            <a href="{{ route('product_price_ranges.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Product Price Ranges">Product Price Ranges</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('product_colors*') ? 'active open' : '' }}">
                            <a href="{{ route('product_colors.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Product Base Colors">Product Base Colors</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('product_thicknesses*') ? 'active open' : '' }}">
                            <a href="{{ route('product_thicknesses.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Product Thickness">Product Thickness</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('product_finishes*') ? 'active open' : '' }}">
                            <a href="{{ route('product_finishes.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Product Finish">Product Finish</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('pick_ticket_restrictions*') ? 'active open' : '' }}">
                            <a href="{{ route('pick_ticket_restrictions.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="PickTicket Restriction">PickTicket Restriction</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('adjustment_types*') ? 'active open' : '' }}">
                            <a href="{{ route('adjustment_types.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Adjustment Type">Adjustment Type</div>
                            </a>
                        </li>

                        <li class="menu-item {{ request()->is('inventory_adjustment_reason_codes') ? 'active' : '' }}">
                            <a href="{{ route('inventory_adjustment_reason_codes.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Inventory Adjustment Reason Code" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary" title="Inventory Adjustment Reason Code">Inventory Adjustment Reason Code</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('countries*') ? 'active open' : '' }}">
                            <a href="{{ route('countries.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Countries of Origin">Countries of Origin</div>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Pre Sales/CRM -->
                <li class="menu-item {{ request()->is('project_types*') || request()->is('sub_headings*')||request()->is('calculate_measurement_labels*')||request()->is('event_types*')||request()->is('opportunity_stages*')||request()->is('probability_to_closes*')||request()->is('release_reason_codes*')|| request()->is('end_use_segments*')||request()->is('about_us_options*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div class="text-truncate" data-i18n="Pre Sales/CRM">Pre Sales/CRM</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->is('opportunity_stages') ? 'active open' : '' }}">
                            <a href="{{ route('opportunity_stages.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Opportunity Stages">Opportunity Stages</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('probability_to_closes') ? 'active open' : '' }}">
                            <a href="{{ route('probability_to_closes.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Probability To Close %" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary" title="Probability To Close %">Probability To Close %</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('event_types') ? 'active open' : '' }}">
                            <a href="{{ route('event_types.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="CRM Event Type">CRM Event Type</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('project_types') ? 'active open' : '' }}">
                            <a href="{{ route('project_types.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Project Type">Project Type</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('end_use_segments') ? 'active open' : '' }}">
                            <a href="{{ route('end_use_segments.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="End-use Segments">End-use Segments </div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('calculate_measurement_labels') ? 'active open' : '' }}">
                            <a href="{{ route('calculate_measurement_labels.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Calculate Measurement Label" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary" title="Calculate Measurement Label">Calculate Measurement Label</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('about_us_options') ? 'active open' : '' }}">
                            <a href="{{ route('about_us_options.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="How Did You Hear About Us Options" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary" title="How Did You Hear About Us Options">How Did You Hear About Us Options</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('sub_headings') ? 'active' : '' }}">
                            <a href="{{ route('sub_headings.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Commonly Used
                                    Subheadings" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary" title="Commonly Used
                                    Subheadings">Commonly Used
                                    Subheadings</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('release_reason_codes') ? 'active' : '' }}">
                            <a href="{{ route('release_reason_codes.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Hold Release Reason Codes" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary" title="Hold Release Reason Codes">Hold Release Reason Codes</div>
                            </a>
                        </li>

                    </ul>
                </li>

                <!--  Sales -->
                <li class="menu-item {{ request()->is('customer_types') || request()->is('shipment_methods')||request()->is('customer_contact_titles')||request()->is('survey_questions') ||request()->is('credit_check_settings')||request()->is('return_reason_codes')||request()->is('price_list_labels') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div class="text-truncate" data-i18n="Sales">Sales</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->is('customer_types')||request()->is('customer_contact_titles')  ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <div class="text-truncate" data-i18n="Customers">Customers</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item {{ request()->is('customer_types') ? 'active open' : '' }}">
                                    <a href="{{ route('customer_types.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Customer Type">Customer Type</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('customer_contact_titles') ? 'active open' : '' }}">
                                    <a href="{{ route('customer_contact_titles.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Customer Contact Titles " data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary" title="Customer Contact Titles">Customer Contact Titles </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item {{ request()->is('shipment_methods')||request()->is('survey_questions')||request()->is('return_reason_codes')||request()->is('credit_check_settings')  ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <div class="text-truncate" data-i18n="Sales Order">Sales Order</div>
                            </a>
                            <ul class="menu-sub">

                                <li class="menu-item {{ request()->is('shipment_methods') ? 'active open' : '' }}">
                                    <a href="{{ route('shipment_methods.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Shipment Methods">Shipment Methods</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('survey_questions') ? 'active open' : '' }}">
                                    <a href="{{ route('survey_questions.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Survey Questions">Survey Questions</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('return_reason_codes') ? 'active open' : '' }}">
                                    <a href="{{ route('return_reason_codes.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Return Reason Codes">Return Reason Codes</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('credit_check_settings') ? 'active open' : '' }}">
                                    <a href="{{ route('credit_check_settings.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Credit Lock">Credit Lock</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item {{ request()->is('price_list_labels')  ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <div class="text-truncate" data-i18n="Pricing">Pricing</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item {{ request()->is('price_list_labels') ? 'active open' : '' }}">
                                    <a href="{{ route('price_list_labels.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Price List Labels">Price List Labels</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!--  Purchase/Payables -->
                <li class="menu-item {{ request()->is('supplier_types')||request()->is('vendor_types')||request()->is('shipment_terms')||request()->is('supplier_ports')||request()->is('supplier_return_statuses')||request()->is('purchase_shipment_methods') ||request()->is('receiving_qc_notes')||request()->is('supplier_cost_list_labels')? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div class="text-truncate" data-i18n="Purchase/Payables">Purchase / Payables</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->is('supplier_types')||request()->is('supplier_ports')  ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <div class="text-truncate" data-i18n="Suppliers">Suppliers</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item {{ request()->is('supplier_types') ? 'active open' : '' }}">
                                    <a href="{{ route('supplier_types.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Supplier Types">Supplier Types</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('supplier_ports') ? 'active open' : '' }}">
                                    <a href="{{ route('supplier_ports.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Supplier Ports">Supplier Ports</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item {{ request()->is('vendor_types')  ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <div class="text-truncate" data-i18n="Vendors">Vendors</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item {{ request()->is('vendor_types') ? 'active open' : '' }}">
                                    <a href="{{ route('vendor_types.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Vendor Types">Vendor Types</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item {{ request()->is('shipment_terms')||request()->is('purchase_shipment_methods')||request()->is('receiving_qc_notes')||request()->is('supplier_return_statuses')||request()->is('supplier_cost_list_labels')  ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <div class="text-truncate" data-i18n="Purchasing">Purchasing</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item {{ request()->is('shipment_terms') ? 'active open' : '' }}">
                                    <a href="{{ route('shipment_terms.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Shipment Terms">Shipment Terms</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('purchase_shipment_methods') ? 'active open' : '' }}">
                                    <a href="{{ route('purchase_shipment_methods.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Purchase Shipment Methods" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary" title="Purchase Shipment Methods">Purchase Shipment Methods</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('receiving_qc_notes') ? 'active open' : '' }}">
                                    <a href="{{ route('receiving_qc_notes.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Receiving QC Notes">Receiving QC Notes</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('supplier_return_statuses') ? 'active open' : '' }}">
                                    <a href="{{ route('supplier_return_statuses.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Supplier Return Statuses" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary" title="Supplier Return Statuses">Supplier Return Statuses</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('supplier_cost_list_labels') ? 'active open' : '' }}">
                                    <a href="{{ route('supplier_cost_list_labels.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Supplier Cost List Labels" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary" title="Supplier Cost List Labels">Supplier Cost List Labels</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!--  Accounting -->
                <li class="menu-item {{ request()->is('default_link_accounts')||request()->is('expense_categories')||request()->is('account_payment_terms')||request()->is('payment_methods')||request()->is('account_receivable_aging_periods')||request()->is('aging_periods_aps')||request()->is('linked_accounts')||request()->is('account_types') ||request()->is('account_sub_types')||request()->is('tax_exempt_reasons')? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div class="text-truncate" data-i18n="Accounting">Accounting</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->is('account_types')||request()->is('account_sub_types')||request()->is('linked_accounts')  ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <div class="text-truncate" data-i18n="Accounts">Accounts</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item {{ request()->is('account_types') ? 'active open' : '' }}">
                                    <a href="{{ route('account_types.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Accounts Type">Accounts Type</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('account_sub_types') ? 'active open' : '' }}">
                                    <a href="{{ route('account_sub_types.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Account Sub Types">Account Sub Types </div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('linked_accounts') ? 'active open' : '' }}">
                                    <a href="{{ route('linked_accounts.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Linked Accounts">Linked Accounts</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item {{ request()->is('default_link_accounts') ? 'active open' : '' }}">
                            <a href="{{ route('default_link_accounts.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Default Link Accounts" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary" title="Default Link Accounts">Default Link Accounts</div>
                            </a>
                        </li>


                        <li class="menu-item {{ request()->is('expense_categories') ? 'active open' : '' }}">
                            <a href="{{ route('expense_categories.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Expense Categories">Expense Categories</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('account_payment_terms') ? 'active open' : '' }}">
                            <a href="{{ route('account_payment_terms.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Payment Terms">Payment Terms</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('payment_methods') ? 'active open' : '' }}">
                            <a href="{{ route('payment_methods.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Payment Methods">Payment Methods</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('account_receivable_aging_periods') ? 'active open' : '' }}">
                            <a href="{{ route('account_receivable_aging_periods.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Aging Periods - AR">Aging Periods - AR</div>
                            </a>
                        </li>

                        <li class="menu-item {{ request()->is('aging_periods_aps') ? 'active open' : '' }}">
                            <a href="{{ route('aging_periods_aps.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Aging Periods - AP">Aging Periods - AP</div>
                            </a>
                        </li>


                        <li class="menu-item {{ request()->is('tax_exempt_reasons') ? 'active open' : '' }}">
                            <a href="{{ route('tax_exempt_reasons.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Tax Exempt Reasons">Tax Exempt Reasons</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</aside>