<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-11-23 20:50:42 --> Severity: Notice --> Trying to get property 'Company_Logo_org' of non-object C:\xampp\htdocs\ajmine_mart\application\controllers\Administrator\Login.php 23
ERROR - 2025-11-23 22:16:24 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting function (T_FUNCTION) or const (T_CONST) C:\xampp\htdocs\ajmine_mart\application\controllers\Administrator\Products.php 851
ERROR - 2025-11-23 22:21:35 --> Severity: Notice --> Undefined property: stdClass::$product_id C:\xampp\htdocs\ajmine_mart\application\controllers\Administrator\Products.php 795
ERROR - 2025-11-23 22:21:35 --> Severity: Notice --> Undefined property: stdClass::$discount_type C:\xampp\htdocs\ajmine_mart\application\controllers\Administrator\Products.php 796
ERROR - 2025-11-23 22:21:35 --> Query error: Column 'product_id' cannot be null - Invalid query: INSERT INTO `tbl_campaign_product` (`campaign_id`, `product_id`, `campaign_quantity`, `AddBy`, `AddTime`, `branch_id`) VALUES (1, NULL, NULL, 'Admin', '2025-11-23 22:21:35', '1')
ERROR - 2025-11-23 22:21:42 --> Severity: Notice --> Undefined property: stdClass::$product_id C:\xampp\htdocs\ajmine_mart\application\controllers\Administrator\Products.php 795
ERROR - 2025-11-23 22:21:42 --> Severity: Notice --> Undefined property: stdClass::$discount_type C:\xampp\htdocs\ajmine_mart\application\controllers\Administrator\Products.php 796
ERROR - 2025-11-23 22:21:42 --> Query error: Column 'product_id' cannot be null - Invalid query: INSERT INTO `tbl_campaign_product` (`campaign_id`, `product_id`, `campaign_quantity`, `AddBy`, `AddTime`, `branch_id`) VALUES (2, NULL, NULL, 'Admin', '2025-11-23 22:21:42', '1')
ERROR - 2025-11-23 22:30:57 --> Severity: Notice --> Undefined property: stdClass::$color C:\xampp\htdocs\ajmine_mart\application\controllers\Administrator\Products.php 325
ERROR - 2025-11-23 22:34:44 --> Severity: Notice --> Undefined property: stdClass::$color C:\xampp\htdocs\ajmine_mart\application\controllers\Administrator\Products.php 325
ERROR - 2025-11-23 22:38:21 --> Severity: Notice --> Undefined property: stdClass::$color C:\xampp\htdocs\ajmine_mart\application\controllers\Administrator\Products.php 301
ERROR - 2025-11-23 22:40:16 --> Severity: Notice --> Undefined property: stdClass::$color C:\xampp\htdocs\ajmine_mart\application\controllers\Administrator\Products.php 301
ERROR - 2025-11-23 22:41:38 --> Severity: Notice --> Undefined property: stdClass::$color C:\xampp\htdocs\ajmine_mart\application\controllers\Administrator\Products.php 301
ERROR - 2025-11-23 22:42:06 --> Severity: Notice --> Undefined property: stdClass::$color C:\xampp\htdocs\ajmine_mart\application\controllers\Administrator\Products.php 301
ERROR - 2025-11-23 22:45:15 --> Severity: Notice --> Undefined property: stdClass::$color C:\xampp\htdocs\ajmine_mart\application\controllers\Administrator\Products.php 301
ERROR - 2025-11-23 23:04:10 --> Query error: Unknown column 'c.branch_id' in 'where clause' - Invalid query: 
                                select
                                    cmp.*,
                                    p.Product_Code,
                                    p.Product_Name
                                from tbl_campaign cmp
                                left join tbl_product p on p.Product_SlNo = cp.product_id
                                where c.branch_id = '1'
                                
                                order by cmp.id desc
ERROR - 2025-11-23 23:04:35 --> Query error: Unknown column 'c.branch_id' in 'where clause' - Invalid query: 
                                select
                                    cmp.*,
                                    p.Product_Code,
                                    p.Product_Name
                                from tbl_campaign cmp
                                left join tbl_product p on p.Product_SlNo = cp.product_id
                                where c.branch_id = '1'
                                
                                order by cmp.id desc
ERROR - 2025-11-23 23:05:03 --> Query error: Unknown column 'c.branch_id' in 'where clause' - Invalid query: 
                                select
                                    cmp.*,
                                    p.Product_Code,
                                    p.Product_Name
                                from tbl_campaign cmp
                                left join tbl_product p on p.Product_SlNo = cp.product_id
                                where c.branch_id = '1'
                                
                                order by cmp.id desc
ERROR - 2025-11-23 23:05:32 --> Query error: Unknown column 'c.branch_id' in 'where clause' - Invalid query: 
                                select
                                    cmp.*,
                                    p.Product_Code,
                                    p.Product_Name
                                from tbl_campaign cmp
                                left join tbl_product p on p.Product_SlNo = cp.product_id
                                where c.branch_id = '1'
                                
                                order by cmp.id desc
ERROR - 2025-11-23 23:06:21 --> Query error: Unknown column 'cpm.product_id' in 'on clause' - Invalid query: 
                                select
                                    cmp.*,
                                    p.Product_Code,
                                    p.Product_Name
                                from tbl_campaign cmp
                                left join tbl_product p on p.Product_SlNo = cpm.product_id
                                where cmp.branch_id = '1'
                                
                                order by cmp.id desc
ERROR - 2025-11-23 23:06:37 --> Query error: Unknown column 'cpm.product_id' in 'on clause' - Invalid query: 
                                select
                                    cmp.*,
                                    p.Product_Code,
                                    p.Product_Name
                                from tbl_campaign cmp
                                left join tbl_product p on p.Product_SlNo = cpm.product_id
                                where cmp.branch_id = '1'
                                
                                order by cmp.id desc
