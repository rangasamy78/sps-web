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
        <li class="menu-item {{ request()->is('states*') || request()->is('bin_types*') || request()->is('file_types*') || request()->is('transaction_startings*') || request()->is('currencies*') || request()->is('departments*')|| request()->is('designations*') ||request()->is('product_types*') ||request()->is('product_price_ranges*')|| request()->is('product_categories*') || request()->is('product_groups*') || request()->is('product_colors*') || request()->is('product_finishes*') || request()->is('countries*') || request()->is('project_types*') || request()->is('sub_headings*')||request()->is('calculate_measurement_labels*')||request()->is('event_types*')||request()->is('opportunity_stages*')||request()->is('probability_to_closes*')||request()->is('release_reason_codes*')|| request()->is('end_use_segments*')||request()->is('about_us_options*')||request()->is('product_thicknesses*')||request()->is('customer_types*') || request()->is('shipment_methods*')||request()->is('customer_contact_titles*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="bx bx-cog menu-icon"></i>
                <div class="text-truncate" data-i18n="System Setting">System Setting</div>
            </a>
            <ul class="menu-sub">
                <!-- Company -->
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
                        <div class="text-truncate" data-i18n="Transaction Starting Numbers" data-bs-toggle="tooltip"
                            data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary"
                            title="Transaction Starting Numbers">Transaction Starting Numbers</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('currencies') ? 'active' : '' }}">
                    <a href="{{ route('currencies.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Currencies">Currencies</div>
                    </a>
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
                <li
                    class="menu-item {{ request()->is('product_types*') || request()->is('product_categories*') || request()->is('product_price_ranges*') || request()->is('product_groups*') || request()->is('product_colors*') || request()->is('product_finishes*') || request()->is('countries*') || request()->is('product_thicknesses*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div class="text-truncate" data-i18n="Products/Inventory">Products/Inventory</div>
                    </a>
                    <ul class="menu-sub">
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
                        <li class="menu-item {{ request()->is('adjustment_types*') ? 'active open' : '' }}">
                            <a href="{{ route('adjustment_types.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Adjustment Type">Adjustment Type</div>
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
                <li
                    class="menu-item {{ request()->is('project_types*') || request()->is('sub_headings*')||request()->is('calculate_measurement_labels*')||request()->is('event_types*')||request()->is('opportunity_stages*')||request()->is('probability_to_closes*')||request()->is('release_reason_codes*')|| request()->is('end_use_segments*')||request()->is('about_us_options*') ? 'active open' : '' }}">
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
                                <div class="text-truncate" data-i18n="Probability To Close %"data-bs-toggle="tooltip"
                            data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary"
                            title="Probability To Close %">Probability To Close %</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('project_types') ? 'active open' : '' }}">
                            <a href="{{ route('project_types.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Project Type">Project Type</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('end_use_segments') ? 'active open' : '' }}">
                            <a href="{{ route('end_use_segments.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="End-use Segments ">End-use Segments </div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('calculate_measurement_labels') ? 'active open' : '' }}">
                            <a href="{{ route('calculate_measurement_labels.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Calculate Measurement Label" data-bs-toggle="tooltip"
                            data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary"
                            title="Calculate Measurement Label">Calculate Measurement Label</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('event_types') ? 'active open' : '' }}">
                            <a href="{{ route('event_types.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="CRM Event Type">CRM Event Type</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('about_us_options') ? 'active open' : '' }}">
                            <a href="{{ route('about_us_options.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="How Did You Hear About Us Options" data-bs-toggle="tooltip"
                            data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary"
                            title="How Did You Hear About Us Options">How Did You Hear About Us Options</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!--  Sales -->
                <li
                    class="menu-item {{ request()->is('customer_types*') || request()->is('shipment_methods*')||request()->is('customer_contact_titles*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div class="text-truncate" data-i18n="Sales">Sales</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->is('customer_contact_titles') ? 'active open' : '' }}">
                            <a href="{{ route('customer_contact_titles.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Customer Contact Titles " data-bs-toggle="tooltip"
                            data-bs-offset="0,8" data-bs-placement="right" data-bs-custom-class="tooltip-secondary"
                            title="Customer Contact Titles">Customer Contact Titles </div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('customer_types') ? 'active open' : '' }}">
                            <a href="{{ route('customer_types.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Customer Type">Customer Type</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('shipment_methods') ? 'active open' : '' }}">
                            <a href="{{ route('shipment_methods.index') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="Shipment Methods">Shipment Methods</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</aside>
