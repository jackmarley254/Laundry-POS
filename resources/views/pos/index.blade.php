<x-layout>
    @section('title', 'Point of Sale')

    @section('content')
        <style>
            /* Modern Layout Container */
            .pos-container {
                display: flex;
                height: calc(100vh - 120px);
                margin: -20px;
                background-color: #f4f6f9;
                font-family: 'Segoe UI', Roboto, sans-serif;
            }

            /* Middle Column: Items Grid */
            .pos-items {
                flex: 1;
                padding: 1.5rem;
                overflow-y: auto;
            }
            .item-card {
                background: #fff;
                border-radius: 12px;
                padding: 1rem;
                cursor: pointer;
                transition: all 0.3s ease;
                border: 1px solid #e9ecef;
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            }
            .item-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 20px rgba(0,0,0,0.08);
                border-color: #4e73df;
            }
            .item-img-container {
                width: 70px;
                height: 70px;
                border-radius: 50%;
                background: #f8f9fa;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 0.8rem;
                overflow: hidden;
                border: 2px solid #f0f0f0;
            }
            .item-img-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            /* Right Column: Cart */
            .pos-cart {
                width: 420px;
                background-color: #fff;
                display: flex;
                flex-direction: column;
                border-left: 1px solid #e9ecef;
            }

            /* Clean White Header */
            .cart-header {
                background: #fff;
                padding: 1.5rem;
                border-bottom: 1px solid #e9ecef;
            }

            /* Input Groups */
            .input-card {
                background: #f8f9fa;
                border-radius: 10px;
                padding: 1rem;
                margin-bottom: 1rem;
                border: 1px solid #e9ecef;
            }
            .input-icon-group {
                position: relative;
            }
            .input-icon-group i {
                position: absolute;
                left: 15px;
                top: 10px;
                color: #6c757d;
                font-size: 1rem;
            }
            .input-icon-group input {
                padding-left: 42px;
                height: 42px;
                border-radius: 8px;
                border: 1px solid #dee2e6;
                background: #fff;
            }
            .input-icon-group input:focus {
                border-color: #4e73df;
                box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
            }

            /* Cart Body */
            .cart-body {
                flex: 1;
                overflow-y: auto;
                padding: 1.5rem;
                background: #fdfdff;
            }

            /* Item Card inside Cart */
            .cart-item-card {
                background: #fff;
                border-radius: 12px;
                padding: 1rem;
                margin-bottom: 1rem;
                border: 1px solid #e9ecef;
                box-shadow: 0 2px 4px rgba(0,0,0,0.03);
                transition: transform 0.2s;
                animation: slideIn 0.3s ease-out;
            }
            @keyframes slideIn {
                from { opacity: 0; transform: translateX(20px); }
                to { opacity: 1; transform: translateX(0); }
            }
            
            .qty-modern-controls {
                display: flex;
                align-items: center;
                background: #f4f6f9;
                border-radius: 20px; /* Pill shape */
                overflow: hidden;
                border: 1px solid #e9ecef;
            }
            .qty-btn {
                border: none;
                background: transparent;
                width: 32px;
                height: 32px;
                font-weight: bold;
                cursor: pointer;
                color: #4e73df;
                transition: all 0.2s;
            }
            .qty-btn:hover { background: #e9ecef; }
            
            .qty-display {
                width: 40px;
                text-align: center;
                border: none;
                background: transparent;
                font-weight: 600;
                font-size: 0.95rem;
            }

            /* Cart Footer */
            .cart-footer {
                background: #fff;
                padding: 1.5rem;
                border-top: 1px solid #e9ecef;
            }
            
            .summary-card {
                background: #f8f9fa;
                border-radius: 12px;
                padding: 1rem;
                margin-bottom: 1rem;
                border: 1px solid #e9ecef;
            }

            .btn-process {
                background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
                border: none;
                padding: 14px;
                font-size: 1rem;
                font-weight: 600;
                letter-spacing: 0.5px;
                box-shadow: 0 4px 10px rgba(78, 115, 223, 0.3);
                border-radius: 10px;
            }
            .btn-process:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 15px rgba(78, 115, 223, 0.4);
            }

            .btn-exact {
                background: #fff;
                border: 2px solid #4e73df;
                color: #4e73df;
                font-weight: 600;
                border-radius: 10px;
            }
            .btn-exact:hover {
                background: #4e73df;
                color: #fff;
            }

            /* Scrollbar */
            .cart-body::-webkit-scrollbar { width: 5px; }
            .cart-body::-webkit-scrollbar-thumb { background: #e0e0e0; border-radius: 10px; }
        </style>

        <div class="pos-container">
            <!-- COL 2: Services Grid -->
            <div class="pos-items">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-0 fw-bold text-dark">Select Service</h4>
                        <p class="text-muted small mb-0">Click item to add to order</p>
                    </div>
                    <div class="input-group" style="max-width: 300px; border-radius: 10px;">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="searchServiceInput" class="form-control border-start-0" placeholder="Search services...">
                    </div>
                </div>

                <div class="row g-3" id="serviceContainer">
                    @foreach($services as $service)
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 service-col" data-name="{{ strtolower($service->name) }}">
                            <div class="item-card" onclick="addToCart('{{ $service->id }}', '{{ $service->name }}', {{ $service->price }})">
                                <div class="item-img-container">
                                    @if($service->image)
                                        <img src="{{ asset('images/services/' . $service->image) }}" alt="{{ $service->name }}">
                                    @else
                                        <i class="bi bi-box-seam fs-3 text-primary opacity-50"></i>
                                    @endif
                                </div>
                                <h6 class="mb-1 fw-bold text-dark">{{ $service->name }}</h6>
                                <span class="text-primary fw-bold">Ksh {{ number_format($service->price, 2) }}</span>
                                <small class="text-muted d-block">/ {{ $service->unit }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- COL 3: Order Cart -->
            <div class="pos-cart">
                <!-- Header Section (Outside Form) -->
                <div class="cart-header">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-bag-heart text-primary me-2"></i>Current Order</h5>
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="clearCart()">
                            <i class="bi bi-trash me-1"></i> Clear
                        </button>
                    </div>
                    
                    <!-- Customer Inputs Card -->
                    <div class="input-card">
                        <div class="input-icon-group mb-2">
                            <i class="bi bi-phone"></i>
                            <input type="text" id="search_phone" class="form-control" placeholder="Phone Number" required>
                        </div>

                        <div class="row g-2">
                            <div class="col-7">
                                <div class="input-icon-group mb-0">
                                    <i class="bi bi-person"></i>
                                    <input type="text" id="customer_name" class="form-control" placeholder="Customer Name" required>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="input-icon-group mb-0">
                                    <i class="bi bi-calendar-event"></i>
                                    <input type="date" id="pickup_date" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- *** FIX: FORM STARTS HERE *** -->
                <!-- It wraps the Cart Body so dynamic items are inside the form -->
                <form action="{{ route('pos.store') }}" method="POST" id="posForm">
                    @csrf
                    <!-- Hidden inputs for Laravel -->
                    <input type="hidden" name="customer_phone" id="customer_phone_hidden">
                    <input type="hidden" name="customer_name" id="customer_name_hidden">
                    <input type="hidden" name="pickup_date" id="pickup_date_hidden">

                    <!-- Cart Body -->
                    <div class="cart-body" id="cartContainer">
                        <!-- Empty State -->
                        <div id="emptyState" class="text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-cart-x fs-0 text-muted opacity-25"></i>
                            </div>
                            <h6 class="text-muted">No items in cart</h6>
                            <small class="text-muted">Select items from the left</small>
                        </div>
                        
                        <!-- Cart Items will be injected here via JS -->
                        <div id="cartItems"></div>
                    </div>

                    <!-- Cart Footer -->
                    <div class="cart-footer">                        
                        <div class="summary-card">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span class="text-dark" id="subTotalDisplay">Ksh 0.00</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between">
                                <h5 class="fw-bold mb-0">Total</h5>
                                <h5 class="fw-bold text-primary mb-0" id="grandTotal">Ksh 0.00</h5>
                            </div>
                        </div>

                        <div class="row g-2 align-items-end">
                            <div class="col-5">
                                <label class="small text-muted mb-1 d-block">Pay Amount</label>
                                <input type="number" name="paid_amount" step="0.01" class="form-control form-control-lg text-center fw-bold" id="paid_amount" value="0">
                            </div>
                            <div class="col-7 d-grid gap-2">
                                <button type="button" class="btn btn-exact btn-block" onclick="setExactAmount()">
                                    <i class="bi bi-bullseye me-1"></i> Exact Amount
                                </button>
                                <button type="submit" class="btn btn-primary btn-process btn-block">
                                    <i class="bi bi-check-circle-fill me-2"></i> Process Order
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- *** FIX: FORM ENDS HERE *** -->
            </div>
        </div>
    @endsection

    @push('scripts')
    <script>
        $(document).ready(function() {
            
            // Define rowIndex in the global scope of this script
            window.rowIndex = 0;

            // Set default date
            var today = new Date().toISOString().split('T')[0];
            $('#pickup_date').val(today);

            // ---------------------------------------------------
            // 1. LIVE SEARCH
            // ---------------------------------------------------
            $('#searchServiceInput').on('keyup', function(){
                var value = $(this).val().toLowerCase();
                $('#serviceContainer .service-col').filter(function() {
                    $(this).toggle($(this).data('name').indexOf(value) > -1);
                });
            });

            // ---------------------------------------------------
            // 2. CUSTOMER SEARCH
            // ---------------------------------------------------
            $('#search_phone').on('keyup', function(){
                var query = $(this).val();
                if(query.length > 2){
                    $.ajax({
                        url: "{{ route('pos.searchCustomer') }}",
                        type: "GET",
                        data: {'query': query},
                        success: function(data){
                            if(data.length > 0){
                                $('#customer_name').val(data[0].name);
                            }
                        }
                    });
                }
            });

            // ---------------------------------------------------
            // 3. CART FUNCTIONS
            // ---------------------------------------------------
            window.addToCart = function(id, name, price) {
                $('#emptyState').hide();
                
                // Increment global index
                window.rowIndex++;
                var currentIdx = window.rowIndex;
                
                // FIX: Ensure inputs have correct names format: items[index][key]
                var itemHtml = `
                <div class="cart-item-card" id="row${currentIdx}">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">${name}</h6>
                            <small class="text-primary item-price">Ksh ${price.toFixed(2)}</small>
                        </div>
                        <button type="button" class="btn btn-sm text-muted" onclick="removeRow(${currentIdx})" style="line-height: 1;">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="qty-modern-controls">
                            <button type="button" class="qty-btn" onclick="updateQty(${currentIdx}, -1)">−</button>
                            <input type="number" step="0.1" value="1" class="qty-display" id="qty${currentIdx}" name="items[${currentIdx}][quantity]" onchange="calculateTotals()">
                            <button type="button" class="qty-btn" onclick="updateQty(${currentIdx}, 1)">+</button>
                        </div>
                        
                        <!-- Hidden input for Service ID -->
                        <input type="hidden" name="items[${currentIdx}][service_id]" value="${id}">
                        
                        <h5 class="mb-0 text-dark fw-bold subtotal">Ksh ${price.toFixed(2)}</h5>
                    </div>
                </div>`;
                
                $('#cartItems').append(itemHtml);
                calculateTotals();
            };

            window.updateQty = function(id, change) {
                var input = $(`#qty${id}`);
                var currentVal = parseFloat(input.val());
                var newVal = currentVal + change;
                
                if (newVal > 0) {
                    input.val(newVal);
                    calculateTotals();
                } else if (newVal <= 0) {
                    removeRow(id);
                }
            };

            window.removeRow = function(id) {
                $(`#row${id}`).fadeOut(300, function() {
                    $(this).remove();
                    calculateTotals();
                    if($('#cartItems').children().length == 0){
                        $('#emptyState').show();
                    }
                });
            };

            window.clearCart = function() {
                $('#cartItems').empty();
                $('#emptyState').show();
                calculateTotals();
            };

            window.calculateTotals = function() {
                var total = 0;
                $('#cartItems .cart-item-card').each(function(){
                    var qty = parseFloat($(this).find('.qty-display').val());
                    var priceText = $(this).find('.item-price').text();
                    var price = parseFloat(priceText.replace(/[^0-9.-]+/g,"")); 
                    
                    var sub = price * qty;
                    $(this).find('.subtotal').text('Ksh ' + sub.toFixed(2));
                    total += sub;
                });
                
                $('#subTotalDisplay').text('Ksh ' + total.toFixed(2));
                $('#grandTotal').text('Ksh ' + total.toFixed(2));
            };

            // ---------------------------------------------------
            // 4. EXACT AMOUNT BUTTON
            // ---------------------------------------------------
            window.setExactAmount = function() {
                var total = $('#grandTotal').text();
                var amount = parseFloat(total.replace(/[^0-9.-]+/g,""));
                if(!isNaN(amount)) {
                    $('#paid_amount').val(amount.toFixed(2));
                }
            };

            // ---------------------------------------------------
            // 5. FORM SUBMISSION
            // ---------------------------------------------------
            $('#posForm').on('submit', function(e){
                // Validation
                if($('#customer_name').val() == '' || $('#search_phone').val() == '') {
                    e.preventDefault();
                    alert('Please enter customer name and phone.');
                    return false;
                }
                
                if($('#cartItems').children().length == 0) {
                    e.preventDefault();
                    alert('Cart is empty.');
                    return false;
                }

                // Copy data to hidden fields so they are included in the form POST
                $('#customer_phone_hidden').val($('#search_phone').val());
                $('#customer_name_hidden').val($('#customer_name').val());
                $('#pickup_date_hidden').val($('#pickup_date').val());
            });

        });
    </script>
    @endpush
</x-layout>