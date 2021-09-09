<?php 

    class DbOperations{

        private $con; 

        function __construct(){
            require_once dirname(__FILE__) . '/DbConnect.php';
            $db = new DbConnect; 
            $this->con = $db->connect(); 
        }

        public function getAdminByPhone($email){
            $stmt = $this->con->prepare("SELECT user_id, name, email, added_date FROM tblsuper_admin WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute(); 
            $stmt->bind_result($user_id, $name, $email, $added_date);
            $stmt->fetch(); 
            $admin = array(); 
            $admin['id'] = $user_id;
            $admin['full_name'] = $name; 
            $admin['email_address']=$email; 
            $admin['phone_number'] = "0795419063"; 
            $admin['profile_photo'] = ""; 
            $admin['role'] = ""; 
            return $admin; 
        }

        public function getAdminDetails($email)
        {
             $stmt = $this->con->prepare("SELECT user_id, name, email, added_date FROM tblsuper_admin WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($user_id, $name, $email,$added_date);
            $users = array();
            while($stmt->fetch()){
                $user = array();
                $user['user_id'] = $user_id;
                $user['name'] = $name;
                $user['email']=$email;
                $user['added_date'] = $added_date;
                // $user['updatio_date'] = $updatio_date;

                array_push($users, $user);
            }
            return $users;
        }

        public function adminLogin($email, $password){
            if($this->isPhoneExist($email)){
                $hashed_password = $this->getAdminPasswordByPhone($email); 
                if($password == $hashed_password){
                    return USER_AUTHENTICATED;
                }else{
                    return USER_PASSWORD_DO_NOT_MATCH; 
                }
            }else{
                return USER_NOT_FOUND; 
            }
        }



        private function isIdNumberExist($username){
            $stmt = $this->con->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            return $stmt->num_rows > 0;
        }
        private function getUserPasswordById($username){
            $stmt = $this->con->prepare("SELECT password FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($password);
            $stmt->fetch();
            return $password;
        }

        public function createProfilePic($profile_photo, $email){
            $stmt = $this->con->prepare("UPDATE tblsuper_admin SET profile_photo = ? WHERE email = ?");
            $stmt->bind_param("ss", $profile_photo, $email);
            if($stmt->execute())
                return true;
            return false;
        }

        

        private function isPhoneExist($email){
            $stmt = $this->con->prepare("SELECT user_id FROM tblsuper_admin WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0;  
        }

        private function getAdminPasswordByPhone($email){
            $stmt = $this->con->prepare("SELECT password FROM tblsuper_admin WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute(); 
            $stmt->bind_result($password);
            $stmt->fetch(); 
            return $password; 
        }

        public function countTotalFloor(){
            $stmt = $this->con->prepare("SELECT fid FROM tbl_add_floor");
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function countTotalUnit(){
            $stmt = $this->con->prepare("SELECT uid FROM tbl_add_unit");
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function countVaccant($status){
            $stmt = $this->con->prepare("SELECT uid FROM tbl_add_unit WHERE status = ?");
            $stmt->bind_param("i", $status);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function getTotalMaintenance(){
            $stmt = $this->con->prepare("SELECT SUM(m_amount) AS total_maintenance FROM tbl_add_maintenance_cost");
            $stmt->execute(); 
            $stmt->bind_result($total_maintenance);
            $stmt->fetch(); 
            return $total_maintenance; 
        }

        public function getTotalBill(){
            $stmt = $this->con->prepare("SELECT SUM(total_amount) AS total_bill FROM tbl_add_bill");
            $stmt->execute(); 
            $stmt->bind_result($total_bill);
            $stmt->fetch(); 
            return $total_bill; 
        }

        public function getTotalRentCollected(){
            $stmt = $this->con->prepare("SELECT SUM(total_rent) AS total_rent FROM tbl_add_fair");
            $stmt->execute(); 
            $stmt->bind_result($total_rent);
            $stmt->fetch(); 
            return $total_rent; 
        }

        public function getTotalDepositCollected(){
            $stmt = $this->con->prepare("SELECT SUM(deposit) AS deposit FROM tbl_add_rent");
            $stmt->execute(); 
            $stmt->bind_result($deposit);
            $stmt->fetch(); 
            return $deposit; 
        }

        public function getTotalAdvanceBalance(){
            $stmt = $this->con->prepare("SELECT SUM(r_advance) AS r_advance FROM tbl_add_rent");
            $stmt->execute(); 
            $stmt->bind_result($r_advance);
            $stmt->fetch(); 
            return $r_advance; 
        }

        public function countTenants(){
            $stmt = $this->con->prepare("SELECT rid FROM tbl_add_rent");
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function getAllAccounts(){
            $stmt = $this->con->prepare("SELECT id, account_name, account_balance, balance_as_of FROM tbl_accounts  ORDER BY id DESC");
            $stmt->execute(); 
            $stmt->bind_result($id, $account_name, $account_balance, $balance_as_of);
            $accounts = array(); 
            while($stmt->fetch()){ 
                $account = array(); 
                $account['id'] = $id; 
                $account['account_name']= $account_name; 
                $account['account_balance'] = $account_balance; 
                $account['balance_as_of'] = $balance_as_of; 

                array_push($accounts, $account);
            }             
            return $accounts; 
        }

        public function getAllFloor(){
            $stmt = $this->con->prepare("SELECT fid, floor_no, added_date FROM tbl_add_floor  ORDER BY fid DESC");
            $stmt->execute(); 
            $stmt->bind_result($fid, $floor_no, $added_date);
            $floors = array(); 
            while($stmt->fetch()){ 
                $floor = array(); 
                $floor['fid'] = $fid; 
                $floor['floor_no']= $floor_no; 
                $floor['added_date'] = $added_date; 

                array_push($floors, $floor);
            }             
            return $floors; 
        }

        public function addAccount($account_name, $account_balance, $balance_as_of){
           if(!$this->isAccountExist($account_name)){
                $stmt = $this->con->prepare("INSERT INTO tbl_accounts (account_name, account_balance, balance_as_of) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $account_name, $account_balance, $balance_as_of);
                if($stmt->execute()){
                    return USER_CREATED; 
                }else{
                    return USER_FAILURE;
                }
            }
            return USER_EXISTS; 
        }

        //my code

        public function addMedicine($medicine_name, $category, $expire_date,$qty,$size,$status,$remaining_date){
           if(!$this->isMedicineExist($medicine_name)){
                $stmt = $this->con->prepare("INSERT INTO doses (medicine_name, category, expire_date, qty,size, status,remaining_date) VALUES (?, ?,?,?,?,?,?)");
                $stmt->bind_param("sssssss", $medicine_name, $category, $expire_date, $qty,$size, $status,$remaining_date);
                if($stmt->execute()){
                    return USER_CREATED; 
                }else{
                    return USER_FAILURE;
                }
            }
            return USER_EXISTS; 
        }

        private function isMedicineExist($medicine_name){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE medicine_name = ?");
            $stmt->bind_param("s", $medicine_name);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0;  
        }

        public function getAllMedicineDetailsById($dose_id){
            $stmt = $this->con->prepare("SELECT dose_id, medicine_name, category, expire_date, qty, size, status,remaining_date FROM doses WHERE dose_id = ?");
            $stmt->bind_param("i", $dose_id);
            $stmt->execute(); 
            $stmt->bind_result($dose_id, $medicine_name, $category, $expire_date,$qty,$size,$status,$remaining_date);
            $stmt->fetch(); 
            $medicine = array(); 
            $medicine['dose_id'] = $dose_id; 
            $medicine['medicine_name']= $medicine_name; 
            $medicine['category']= $category; 
            $medicine['expire_date'] = $expire_date; 
            $medicine['qty'] = $qty; 
            $medicine['size'] = $size; 
            $medicine['status'] = $status; 
            $medicine['remaining_date'] = $remaining_date; 
            return $medicine; 
        }

        public function deleteMedicine($dose_id){
            $stmt = $this->con->prepare("DELETE FROM doses WHERE dose_id = ?");
            $stmt->bind_param("i", $dose_id);
            if($stmt->execute())
                return true; 
            return false; 
        }

        public function getAllMedicine(){
            $stmt = $this->con->prepare("SELECT dose_id, medicine_name, category, expire_date, qty, size, status,remaining_date FROM doses  ORDER BY dose_id DESC");
            $stmt->execute(); 
            $stmt->bind_result($dose_id, $medicine_name, $category, $expire_date, $qty,$size,$status,$remaining_date);
            $medicines = array(); 
            while($stmt->fetch()){ 
                $medicine = array(); 
                $medicine['dose_id'] = $dose_id; 
                $medicine['medicine_name']= $medicine_name; 
                $medicine['category'] = $category; 
                $medicine['expire_date'] = $expire_date; 
                $medicine['qty'] = $qty; 
                $medicine['size'] = $size; 
                $medicine['status'] = $status; 
                $medicine['remaining_date'] = $remaining_date; 

                array_push($medicines, $medicine);
            }             
            return $medicines; 
        }

        public function updateMedicineDetails($medicine_name, $category, $expire_date, $qty,$size, $dose_id){
            $stmt = $this->con->prepare("UPDATE doses SET medicine_name = ?, category = ?, expire_date = ?, qty = ?, size = ?   WHERE dose_id = ?");
            $stmt->bind_param("sssssi", $medicine_name, $category, $expire_date, $qty, $size,  $dose_id);

            if($stmt->execute()) {
                return UPDATED;
            } else {
                return NOT_UPDATED; 
            }
        }


        public function totalMessagesExpire(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE remaining_date <= 3 ");
            // $stmt = bind_param('s',$remaining_date );
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function updateStatusDetails($status, $dose_id){
            $stmt = $this->con->prepare("UPDATE doses SET status = ? WHERE dose_id = ?");
            $stmt->bind_param("si", $status, $dose_id);
            if($stmt->execute()) {
                return UPDATED;
            } else {
                return NOT_UPDATED; 
            }
        }

         public function countTotalMedicine(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses");
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function countTotalDrop(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE category = 'drop'");
            // $stmt = bind_param('s',$category);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function countTotalInhalers(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE category = 'inhaler'");
            // $stmt = bind_param('s',$category);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        

        public function countTotalInjections(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE category = 'injection'");
            // $stmt = bind_param('s',$category);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function countTotalSuppositories(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE category = 'Suppositorie'");
            // $stmt = bind_param('s',$category);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }
        public function countTotalTopicalMedicines(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE category = 'Topical Medicine'");
            // $stmt = bind_param('s',$category);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function countTotalTopicalCapsules(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE category = 'Capsules'");
            // $stmt = bind_param('s',$category);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function countTotalTopicalTablet(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE category = 'Tablet'");
            // $stmt = bind_param('s',$category);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function countTotalTopicalLiquid(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE category = 'Liquid'");
            // $stmt = bind_param('s',$category);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function updatePassword($currentpassword, $newpassword, $username){
            $hashed_password = $this->getUserPasswordById($username);
            
            if(password_verify($currentpassword, $hashed_password)){
                
                $hash_password = password_hash($newpassword, PASSWORD_DEFAULT);
                $stmt = $this->con->prepare("UPDATE users SET password = ? WHERE username = ?");
                $stmt->bind_param("ss",$hash_password, $username);

                if($stmt->execute())
                    return PASSWORD_CHANGED;
                return PASSWORD_NOT_CHANGED;

            }else{
                return PASSWORD_DO_NOT_MATCH; 
            }
        }
        



      }

