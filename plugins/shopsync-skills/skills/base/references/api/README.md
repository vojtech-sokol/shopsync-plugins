# BaseLinker API — Local Documentation

Mirror of <https://api.baselinker.com/> generated 2026-05-21. One markdown file per method, grouped into category subfolders. English (source language).

## Global request information

- **Endpoint:** `POST https://api.baselinker.com/connector.php`
- **Auth header:** `X-BLToken: <your_token>`
- **Body (application/x-www-form-urlencoded):**
  - `method` — method name (e.g. `addOrder`)
  - `parameters` — JSON-encoded string with method-specific parameters
- **Rate limit:** 100 requests / minute

### PHP request template

```php
<?php
$methodParams = json_encode([
    // method-specific parameters here
]);

$apiParams = [
    "method"     => "addOrder",
    "parameters" => $methodParams,
];

$curl = curl_init("https://api.baselinker.com/connector.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-BLToken: xxx"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);
$data = json_decode($response, true);
```

### Response envelope

Every response is JSON. Success:
```json
{ "status": "SUCCESS", ...method-specific fields... }
```
Error:
```json
{ "status": "ERROR", "error_code": "ERROR_X", "error_message": "..." }
```

---

## Method index (by category)

### Orders → [`orders/`](orders/)
- [addOrder](orders/addOrder.md)
- [addOrderBySplit](orders/addOrderBySplit.md)
- [addOrderDuplicate](orders/addOrderDuplicate.md)
- [deleteOrders](orders/deleteOrders.md)
- [getOrderTransactionData](orders/getOrderTransactionData.md)
- [getOrders](orders/getOrders.md)
- [getOrdersByEmail](orders/getOrdersByEmail.md)
- [getOrdersByPhone](orders/getOrdersByPhone.md)
- [setOrderFields](orders/setOrderFields.md)
- [setOrdersMerge](orders/setOrdersMerge.md)

### Order Products → [`order-products/`](order-products/)
- [addOrderProduct](order-products/addOrderProduct.md)
- [deleteOrderProduct](order-products/deleteOrderProduct.md)
- [setOrderProductFields](order-products/setOrderProductFields.md)

### Payments → [`payments/`](payments/)
- [getOrderPaymentsHistory](payments/getOrderPaymentsHistory.md)
- [setOrderPayment](payments/setOrderPayment.md)

### Statuses → [`statuses/`](statuses/)
- [getOrderStatusList](statuses/getOrderStatusList.md)
- [setOrderStatus](statuses/setOrderStatus.md)
- [setOrderStatuses](statuses/setOrderStatuses.md)

### Invoices → [`invoices/`](invoices/)
- [addInvoice](invoices/addInvoice.md)
- [addInvoiceCorrection](invoices/addInvoiceCorrection.md)
- [addOrderInvoiceFile](invoices/addOrderInvoiceFile.md)
- [getInvoiceFile](invoices/getInvoiceFile.md)
- [getInvoices](invoices/getInvoices.md)
- [getSeries](invoices/getSeries.md)

### Receipts → [`receipts/`](receipts/)
- [addOrderReceiptFile](receipts/addOrderReceiptFile.md)
- [addReceipt](receipts/addReceipt.md)
- [getNewReceipts](receipts/getNewReceipts.md)
- [getReceipt](receipts/getReceipt.md)
- [getReceipts](receipts/getReceipts.md)
- [setOrderReceipt](receipts/setOrderReceipt.md)

### PickPack Carts → [`pickpack-carts/`](pickpack-carts/)
- [getPickPackCarts](pickpack-carts/getPickPackCarts.md)

### Orders — other → [`orders-other/`](orders-other/)
- [getJournalList](orders-other/getJournalList.md)
- [getOrderExtraFields](orders-other/getOrderExtraFields.md)
- [getOrderPickPackHistory](orders-other/getOrderPickPackHistory.md)
- [getOrderPrintoutTemplates](orders-other/getOrderPrintoutTemplates.md)
- [getOrderSources](orders-other/getOrderSources.md)
- [runOrderMacroTrigger](orders-other/runOrderMacroTrigger.md)

### Order Returns → [`order-returns/`](order-returns/)
- [addOrderReturn](order-returns/addOrderReturn.md)
- [getOrderReturnExtraFields](order-returns/getOrderReturnExtraFields.md)
- [getOrderReturns](order-returns/getOrderReturns.md)
- [setOrderReturnFields](order-returns/setOrderReturnFields.md)

### Return Products → [`return-products/`](return-products/)
- [addOrderReturnProduct](return-products/addOrderReturnProduct.md)
- [deleteOrderReturnProduct](return-products/deleteOrderReturnProduct.md)
- [setOrderReturnProductFields](return-products/setOrderReturnProductFields.md)

### Return Statuses → [`return-statuses/`](return-statuses/)
- [getOrderReturnProductStatuses](return-statuses/getOrderReturnProductStatuses.md)
- [getOrderReturnReasonsList](return-statuses/getOrderReturnReasonsList.md)
- [getOrderReturnStatusList](return-statuses/getOrderReturnStatusList.md)
- [setOrderReturnStatus](return-statuses/setOrderReturnStatus.md)
- [setOrderReturnStatuses](return-statuses/setOrderReturnStatuses.md)

### Return Payments → [`return-payments/`](return-payments/)
- [getOrderReturnPaymentsHistory](return-payments/getOrderReturnPaymentsHistory.md)
- [setOrderReturnRefund](return-payments/setOrderReturnRefund.md)

### Returns — other → [`returns-other/`](returns-other/)
- [getOrderReturnJournalList](returns-other/getOrderReturnJournalList.md)
- [runOrderReturnMacroTrigger](returns-other/runOrderReturnMacroTrigger.md)

### Courier Packages → [`courier-packages/`](courier-packages/)
- [createPackage](courier-packages/createPackage.md)
- [createPackageManual](courier-packages/createPackageManual.md)
- [deleteCourierPackage](courier-packages/deleteCourierPackage.md)
- [getCourierPackagesStatusHistory](courier-packages/getCourierPackagesStatusHistory.md)
- [getOrderPackages](courier-packages/getOrderPackages.md)
- [getPackageDetails](courier-packages/getPackageDetails.md)

### Courier Info → [`courier-info/`](courier-info/)
- [getCourierAccounts](courier-info/getCourierAccounts.md)
- [getCourierFields](courier-info/getCourierFields.md)
- [getCourierServices](courier-info/getCourierServices.md)
- [getCouriersList](courier-info/getCouriersList.md)

### Courier Labels & Protocols → [`courier-labels/`](courier-labels/)
- [getCourierDocument](courier-labels/getCourierDocument.md)
- [getLabel](courier-labels/getLabel.md)
- [getProtocol](courier-labels/getProtocol.md)

### Parcel Pickups → [`parcel-pickups/`](parcel-pickups/)
- [getRequestParcelPickupFields](parcel-pickups/getRequestParcelPickupFields.md)
- [runRequestParcelPickup](parcel-pickups/runRequestParcelPickup.md)

### CRM Clients → [`crm-clients/`](crm-clients/)
- [addCrmClient](crm-clients/addCrmClient.md)
- [deleteCrmClient](crm-clients/deleteCrmClient.md)
- [getCrmClientData](crm-clients/getCrmClientData.md)
- [getCrmClientExtraFields](crm-clients/getCrmClientExtraFields.md)
- [getCrmClients](crm-clients/getCrmClients.md)

### CRM Statuses → [`crm-statuses/`](crm-statuses/)
- [getCrmClientStatusGroups](crm-statuses/getCrmClientStatusGroups.md)
- [getCrmClientStatuses](crm-statuses/getCrmClientStatuses.md)

### Inventories → [`inventories/`](inventories/)
- [addInventory](inventories/addInventory.md)
- [deleteInventory](inventories/deleteInventory.md)
- [getInventories](inventories/getInventories.md)

### Price Groups → [`price-groups/`](price-groups/)
- [addInventoryPriceGroup](price-groups/addInventoryPriceGroup.md)
- [deleteInventoryPriceGroup](price-groups/deleteInventoryPriceGroup.md)
- [getInventoryPriceGroups](price-groups/getInventoryPriceGroups.md)

### Warehouses → [`warehouses/`](warehouses/)
- [addInventoryWarehouse](warehouses/addInventoryWarehouse.md)
- [deleteInventoryWarehouse](warehouses/deleteInventoryWarehouse.md)
- [getInventoryWarehouses](warehouses/getInventoryWarehouses.md)

### Locations → [`locations/`](locations/)
- [addInventoryWarehouseLocation](locations/addInventoryWarehouseLocation.md)
- [addInventoryWarehouseLocationType](locations/addInventoryWarehouseLocationType.md)
- [deleteInventoryWarehouseLocation](locations/deleteInventoryWarehouseLocation.md)
- [deleteInventoryWarehouseLocationType](locations/deleteInventoryWarehouseLocationType.md)
- [getInventoryWarehouseLocationTypes](locations/getInventoryWarehouseLocationTypes.md)
- [getInventoryWarehouseLocations](locations/getInventoryWarehouseLocations.md)

### Categories → [`categories/`](categories/)
- [addInventoryCategory](categories/addInventoryCategory.md)
- [deleteInventoryCategory](categories/deleteInventoryCategory.md)
- [getInventoryCategories](categories/getInventoryCategories.md)

### Manufacturers → [`manufacturers/`](manufacturers/)
- [addInventoryManufacturer](manufacturers/addInventoryManufacturer.md)
- [deleteInventoryManufacturer](manufacturers/deleteInventoryManufacturer.md)
- [getInventoryManufacturers](manufacturers/getInventoryManufacturers.md)

### Products → [`products/`](products/)
- [addInventoryProduct](products/addInventoryProduct.md)
- [deleteInventoryProduct](products/deleteInventoryProduct.md)
- [getInventoryProductLogs](products/getInventoryProductLogs.md)
- [getInventoryProductsData](products/getInventoryProductsData.md)
- [getInventoryProductsList](products/getInventoryProductsList.md)
- [getInventoryProductsPrices](products/getInventoryProductsPrices.md)
- [getInventoryProductsStock](products/getInventoryProductsStock.md)
- [runProductMacroTrigger](products/runProductMacroTrigger.md)
- [updateInventoryProductsPrices](products/updateInventoryProductsPrices.md)
- [updateInventoryProductsStock](products/updateInventoryProductsStock.md)

### Documents → [`documents/`](documents/)
- [addInventoryDocument](documents/addInventoryDocument.md)
- [addInventoryDocumentFile](documents/addInventoryDocumentFile.md)
- [addInventoryDocumentItems](documents/addInventoryDocumentItems.md)
- [getInventoryDocumentFile](documents/getInventoryDocumentFile.md)
- [getInventoryDocumentItems](documents/getInventoryDocumentItems.md)
- [getInventoryDocumentSeries](documents/getInventoryDocumentSeries.md)
- [getInventoryDocuments](documents/getInventoryDocuments.md)
- [setInventoryDocumentStatusConfirmed](documents/setInventoryDocumentStatusConfirmed.md)

### Purchase Orders → [`purchase-orders/`](purchase-orders/)
- [addInventoryPurchaseOrder](purchase-orders/addInventoryPurchaseOrder.md)
- [addInventoryPurchaseOrderItems](purchase-orders/addInventoryPurchaseOrderItems.md)
- [getInventoryPurchaseOrderItems](purchase-orders/getInventoryPurchaseOrderItems.md)
- [getInventoryPurchaseOrderSeries](purchase-orders/getInventoryPurchaseOrderSeries.md)
- [getInventoryPurchaseOrders](purchase-orders/getInventoryPurchaseOrders.md)
- [setInventoryPurchaseOrderStatus](purchase-orders/setInventoryPurchaseOrderStatus.md)

### Fulfillment Deliveries → [`fulfillment-deliveries/`](fulfillment-deliveries/)
- [addInventoryFulfillmentDelivery](fulfillment-deliveries/addInventoryFulfillmentDelivery.md)
- [addInventoryFulfillmentDeliveryItems](fulfillment-deliveries/addInventoryFulfillmentDeliveryItems.md)
- [getInventoryFulfillmentDeliveries](fulfillment-deliveries/getInventoryFulfillmentDeliveries.md)
- [getInventoryFulfillmentDeliveryItems](fulfillment-deliveries/getInventoryFulfillmentDeliveryItems.md)

### Suppliers → [`suppliers/`](suppliers/)
- [addInventorySupplier](suppliers/addInventorySupplier.md)
- [deleteInventorySupplier](suppliers/deleteInventorySupplier.md)
- [getInventorySuppliers](suppliers/getInventorySuppliers.md)

### Payers → [`payers/`](payers/)
- [addInventoryPayer](payers/addInventoryPayer.md)
- [deleteInventoryPayer](payers/deleteInventoryPayer.md)
- [getInventoryPayers](payers/getInventoryPayers.md)

### Inventory — other → [`inventory-other/`](inventory-other/)
- [getInventoryAvailableTextFieldKeys](inventory-other/getInventoryAvailableTextFieldKeys.md)
- [getInventoryExtraFields](inventory-other/getInventoryExtraFields.md)
- [getInventoryIntegrations](inventory-other/getInventoryIntegrations.md)
- [getInventoryPrintoutTemplates](inventory-other/getInventoryPrintoutTemplates.md)
- [getInventoryTags](inventory-other/getInventoryTags.md)

### Base Connect — Integrations → [`base-connect/`](base-connect/)
- [getConnectIntegrationContractors](base-connect/getConnectIntegrationContractors.md)
- [getConnectIntegrations](base-connect/getConnectIntegrations.md)

### Base Connect — Contractor Credit → [`contractor-credit/`](contractor-credit/)
- [addConnectContractorCreditSettlement](contractor-credit/addConnectContractorCreditSettlement.md)
- [getConnectContractorCreditHistory](contractor-credit/getConnectContractorCreditHistory.md)
- [setConnectContractorCreditLimit](contractor-credit/setConnectContractorCreditLimit.md)

### External Storage → [`external-storage/`](external-storage/)
- [getExternalStorageCategories](external-storage/getExternalStorageCategories.md)
- [getExternalStorageProductsData](external-storage/getExternalStorageProductsData.md)
- [getExternalStorageProductsList](external-storage/getExternalStorageProductsList.md)
- [getExternalStorageProductsPrices](external-storage/getExternalStorageProductsPrices.md)
- [getExternalStorageProductsQuantity](external-storage/getExternalStorageProductsQuantity.md)
- [getExternalStoragesList](external-storage/getExternalStoragesList.md)
- [updateExternalStorageProductsQuantity](external-storage/updateExternalStorageProductsQuantity.md)
