<?php

//return CMap::mergeArray(
//    require(dirname(__FILE__).'/main.php'),
return array(
    'params' => array(
        'subscribe' => array(
            'invalid_params' => 'Parameter is incorrect', //for webservices
            'success' => 'You have register successfully the Imuzik3G service. For more assistance, please visit: http://3g.imuzik.com.kh or call 1779 (1c/min). Thank you!',
            'success_a1' => '(DK) Chuc mung, Quy khach may man duoc lua chon nghe nhac MIEN PHI 3G mai mai tai dich vu aMusic của MobiFone khi su dung dich vu. Moi quy khach truy cap http://amusic.vn nghe xem tai bai hat va cac clip ca nhac HOT nhat hien nay. Chi tiet lien he 9090 (200d/phut). Ngoai goi cuoc A1 (2.000d/ngay) se tu dong gia han Quy khach khong mat them bat ky chi phi nao khac. De huy dich vu soan HUY A1 gui 9166. Tran trong cam on va chuc quy khach nghe nhac vui ve!',
            'success_a7' => '(DK) Chuc mung, Quy khach may man duoc lua chon nghe nhac MIEN PHI 3G mai mai tai dich vu aMusic của MobiFone khi su dung dich vu. Moi quy khach truy cap http://amusic.vn nghe xem tai bai hat va cac clip ca nhac HOT nhat hien nay. Chi tiet lien he 9090 (200d/phut). Ngoai goi cuoc A7 (7.000d/tuan) se tu dong gia han Quy khach khong mat them bat ky chi phi nao khac. De huy dich vu soan HUY A7 gui 9166. Tran trong cam on va chuc quy khach nghe nhac vui ve!',
            'success_a30' => '(DK) Quy khach da dang ky thanh cong dich vu am nhac Amusic cua MobiFone (Goi A30, 30.000d/thang), goi cuoc tu dong gia han. De huy dich vu soan HUY A30 gui 9166. Truy cap http://amusic.vn de nghe xem tai cac bai hat, Clip ca nhac dac sac nhat hien nay (hoan toan mien phi cuoc GPRS/3G toc do cao ). Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'success_km_a1' => '(DK) Chuc mung, Quy khach may man duoc lua chon nghe nhac MIEN PHI 3G mai mai tai dich vu aMusic của MobiFone khi su dung dich vu. Moi quy khach truy cap http://amusic.vn nghe xem tai bai hat va clip cac ca nhac HOT nhat hien nay . Hoan toan mien phi su dung 05 ngay. Chi tiet lien he 9090 (200d/phut). Ngoai goi cuoc A1 (2.000d/ngay) se tu dong gia han Quy khach khong mat them bat ky chi phi nao khac. De huy dich vu soan HUY A1 gui 9166. Tran trong cam on!',
            'success_km_a7' => '(DK) Chuc mung, Quy khach may man duoc lua chon nghe nhac MIEN PHI 3G mai mai tai dich vu aMusic của MobiFone khi su dung dich vu. Moi quy khach truy cap http://amusic.vn nghe xem tai bai hat va clip cac ca nhac HOT nhat hien nay . Hoan toan mien phi su dung 05 ngay. Chi tiet lien he 9090 (200d/phut). Ngoai goi cuoc A7 (7.000d/tuan) se tu dong gia han Quy khach khong mat them bat ky chi phi nao khac. De huy dich vu soan HUY A7 gui 9166. Tran trong cam on!',
            'success_km_a30' => ' (DK) Chuc mung, Quy khach duoc MIEN PHI 07 ngay nghe xem tai bai hat va cac clip ca nhac HOT nhat hien nay tai dich vu Amusic cua MobiFone. Moi quy khach truy cap http://amusic.vn (Hoan toan mien phi cuoc GPRS/3G toc do cao). Goi cuoc A30 (30.000d/thang) se tu dong gia han. De huy dich vu soan HUY A30 gui 9166. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'success_km_big' => 'Chuc mung, Quy khach duoc MIEN PHI 01 ngay nghe xem tai bai hat va cac clip ca nhac HOT nhat hien nay tai dich vu Amusic cua MobiFone (hoan toan mien phi cuoc GPRS/3G), de huy dich vu soan HUY A1 gui 9166. Hay cap nhat lien tuc cac bai hat, video Clip HOT nhat hien nay tai http://amusic.vn (sau KM 2.000d/ngay). Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'success_kmtq' => 'Chuc mung, Quy khach duoc MIEN PHI 15 ngay nghe xem tai bai hat va cac clip ca nhac HOT nhat hien nay tai http://amusic.vn cua MobiFone. Gia sau KM: 2000d/ngay. De huy, soan HUY A1 gui 9166. Chi tiet L/H: 9090 (200d/phut). Tran trong cam on!',

            'duplicate_package_a1' => 'Quy khach hien dang su dung goi A1 - 2000d/ngay, co thoi han den :EXPIRED. Truy cap http://amusic.vn de thuong thuc MIEN PHI cac bai hat va clip ca nhac HOT nhat hien nay. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
        	'duplicate_package_a7' => 'Quy khach hien dang su dung goi A7 - 7000d/tuan, co thoi han den :EXPIRED. Truy cap http://amusic.vn de thuong thuc MIEN PHI cac bai hat va clip ca nhac HOT nhat hien nay. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
        	'duplicate_package_a30' => 'Quy khach hien dang su dung goi A30 - 30000d/thang, co thoi han den :EXPIRED. Truy cap http://amusic.vn de thuong thuc MIEN PHI cac bai hat va clip ca nhac HOT nhat hien nay. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
        	'balance_too_low' => 'Tài khoản của Quý khách không đủ để đăng ký gói [Tengoi]. Vui lòng nạp thêm tiền vào đăng ký.',
        	'balance_too_low_a1' => 'Xin loi, tai khoan cua quy khach khong du tien. Vui long nap them tien vao tai khoan de dang ky dich vu hoac soan tin DK A1 gui 9166 (2.000 d/ngay), DK A7 gui 9166 (7.000d/tuan). Truy cap http://amusic.vn de biet them chi tiet. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
        	'balance_too_low_a7' => 'Xin loi, tai khoan cua quy khach khong du tien. Vui long nap them tien vao tai khoan de dang ky dich vu hoac soan tin DK A1 gui 9166 (2.000 d/ngay), DK A7 gui 9166 (7.000d/tuan). Truy cap http://amusic.vn de biet them chi tiet. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
        	'balance_too_low_a30' => 'Xin loi, tai khoan cua quy khach khong du tien. Vui long nap them tien vao tai khoan de dang ky dich vu hoac soan tin DK A1 gui 9166 (2.000d/ngay), DK A7 gui 9166 (7.000d/tuan), DK A30 gui 9166 (30.000đ/thang). Truy cap http://amusic.vn de biet them chi tiet. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
        	'fail_feedata' => 'Hien he thong dang ban. Quy khach vui long thu lai sau. Tran trong cam on!',

            'success_otp_password' => 'Ban vua thuc hien thao tac lay mat khau tren dich vu Amusic, ma xac thuc cua ban la :OTP. Luu y: Ma xac thuc chi co hieu luc trong vong 24h.',
            'success_password' => 'Mat khau cua tai khoan :PHONE tren dich vu Amusic la :PASS. Moi quy khach dang nhap http://amusic.vn de su dung. Luu y: Mat khau chi co hieu luc trong vong 24h.',
            'success_send_password' =>'Mat khau cua tai khoan :PHONE tren dich vu Amusic la :PASS. Moi quy khach dang nhap http://amusic.vn de su dung. Luu y: Mat khau chi co hieu luc trong vong 24h.',
            'success_create_account' => 'Quy khach dang thuc hien dang ky tai khoan tren website http://amusic.vn. Ma xac nhan cua quy khach la :OTP',
            'package_not_exist' => 'Goi cuoc ban dang ky khong ton tai tren he thong, vui long soan tin DK A1 gui 9166 (2.000 d/ngay), DK A7 gui 9166 (7.000d/tuan). Truy cap http://amusic.vn de biet them chi tiet. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'blacklist_phone'=>'Yeu cau dang ky khong thanh cong do so dien thoai cua Quy khach thuoc danh sach tu choi dang ky dich vu GTGT cua MobiFone. De dang ky dich vu Quy khach vui long lien he: 9090 (200d/phut). Tran trong cam on!',


            'success_msg_am' => 'Quý khách đang sử dụng gói AM. Qúy khách được hoàn toàn Miễn cước 3G/GPRS khi xem các clip ca nhạc HOT nhất tại gói âm nhạc của MobiFone',
            'success_msg_km_am' => 'Quý khách đang sử dụng gói AM. Qúy khách được Miễn phí 07 ngày nghe bài hát và xem các clip ca nhạc HOT nhất hiện nay. Đặc biệt hoàn toàn Miễn cước 3G/GPRS',
            'success_msg_am7' => 'Quý khách đang sử dụng gói AM7. Qúy khách được hoàn toàn Miễn cước 3G/GPRS khi xem các clip ca nhạc HOT nhất tại gói âm nhạc của MobiFone',
            'success_msg_km_am7' => 'Quý khách đang sử dụng gói AM. Qúy khách được Miễn phí 07 ngày nghe bài hát và xem các clip ca nhạc HOT nhất hiện nay. Đặc biệt hoàn toàn Miễn cước 3G/GPRS',
            'update_subscribe_user_failed' => 'Sorry. An error occurred during subcribe process. Please try again later',//'Có lỗi trong quá trình đăng ky, mời bạn quay lại sau ít phút',
            
            'default' => 'Co loi trong qua trinh tao tai khoan, vui long thu lai sau. Xin cam on.',
            'reset_password'=>'Mat khau su dung dich vu Amusic cua thue bao {:PHONE} la: {:PASSWORD}.',
            'reset_password'=>'Mat khau cua tai khoan {:PHONE} tren dich vu Amusic la {:PASSWORD}. Moi quy khach dang nhap http://amusic.vn de su dung. Luu y: Mat khau chi co hieu luc trong vong 24h.',
            'require_unsubscribe' => '',
            'is_not_mobifone_number'=>'Số điện thoại của bạn phải là thuê bao của Mobifone mới có thể đăng ký được gói cước.',
            'password_success_web'=>'Quy khach dang thuc hien dang ky tai khoan tren website http://amusic.vn/. Ma xac nhan cua quy khach la :PASS.',
            'subscribe_otp'=>'Quy khach dang thuc hien dang ky goi cuoc tren dich vu Amusic http://amusic.vn. Ma xac nhan cua Quy khach la :OTP.',
            'create_account_otp'=>'Quy khach dang thuc hien dang ky tai khoan tren dich vu Amusic. Ma xac nhan cua quy khach la  :OTP.',

            'voice_broadcast'=>'(DK) Chuc mung, Quy khach da dang ky thanh cong dich vu Amusic. Quy khach duoc MobiFone tang 5.000d vao tai khoan chinh sau 02 ngay. Quy khach vui long duy tri trang thai: Dang ky dich vu de duoc huong khuyen mai. Hay truy cap http://amusic.vn de nghe xem tai bai hat va cac clip ca nhac HOT nhat hien nay. Hoan toan mien phi su dung 01 ngay. Sau KM, 2.000d/ngay. De huy dich vu soan HUY A1 gui 9166. Chi tiet lien he 9090 (200 d/phut)',
            'sms_kmtq'=>'Amusic va Funring. Quy khach duoc MobiFone tang 5000d vao tai khoan chinh sau 15 ngay, duy tri trang thai dang ky goi cuoc de huong KM. Truy cap http://amusic.vn de nghe xem tai bai hat, clip HOT. MIEN PHI 15 ngay dich vu Amusic va 1 thang Funring. Chi tiet lien he 9090 (200 d/phut). Sau KM, cuoc Amusic: 2.000d/ngay, Funring 9.000d/30 ngay, BH Funring 5.000d/60 ngay se tu dong gia han. Huy dich vu Amusic: HUY A1 gui 9166, Funring: HUY gui 9224.',
            'success_msg_confirm_a1'=>'(XDK) Quy khach dang yeu cau dang ky goi cuoc A1 cua dich vu Amusic do Mobifone cung cap. De xac nhan dang ky dich vu, soan Y A1 gui 9166. Gia goi 2000 VND/ngay. Yeu cau dang ky se bi huy trong vong 30 phut neu Quy khach khong xac nhan. Chi tiet lien he 900 (200d/phut). Tran trong cam on!',
            'success_msg_confirm_a7'=>'(XDK) Quy khach dang yeu cau dang ky goi cuoc A7 cua dich vu Amusic do Mobifone cung cap. De xac nhan dang ky dich vu, soan Y A7 gui 9166. Gia goi 7000 VND/tuan. Yeu cau dang ky se bi huy trong vong 30 phut neu Quy khach khong xac nhan. Chi tiet lien he 900 (200d/phut). Tran trong cam on!',
            'success_msg_confirm_a30'=>'(XDK) Quy khach dang yeu cau dang ky goi cuoc A30 cua dich vu Amusic do Mobifone cung cap. De xac nhan dang ky dich vu, soan Y A30 gui 9166. Gia goi 30.000 VND/30 ngay. Yeu cau dang ky se bi huy trong vong 30 phut neu Quy khach khong xac nhan. Chi tiet lien he 900 (200d/phut). Tran trong cam on!',
            'success_msg_confirm_km_a1'=>'(XDK) Quy khach dang yeu cau dang ky goi cuoc A1 cua dich vu Amusic do Mobifone cung cap. De xac nhan dang ky dich vu, soan Y A1 gui 9166. Gia goi 2000 VND/ngay, mien phi 05 ngay. Yeu cau dang ky se bi huy trong vong 30 phut neu Quy khach khong xac nhan. Chi tiet lien he 900 (200d/phut). Tran trong cam on!',
            'success_msg_confirm_km_a7'=>'(XDK) Quy khach dang yeu cau dang ky goi cuoc A7 cua dich vu Amusic do Mobifone cung cap. De xac nhan dang ky dich vu, soan Y A7 gui 9166. Gia goi 7000VND/tuan, mien phi 05 ngay. Yeu cau dang ky se bi huy trong vong 30 phut neu Quy khach khong xac nhan. Chi tiet lien he 900 (200d/phut). Tran trong cam on!',
            'success_msg_confirm_km_a30'=>'(XDK) Quy khach dang yeu cau dang ky goi cuoc A30 cua dich vu Amusic do Mobifone cung cap. De xac nhan dang ky dich vu, soan Y A30 gui 9166. Gia goi 30.000VND/tuan, mien phi 07 ngay. Yeu cau dang ky se bi huy trong vong 30 phut neu Quy khach khong xac nhan. Chi tiet lien he 900 (200d/phut). Tran trong cam on!',
            'cancel_request_package'=>'Goi cuoc %s cua dich vu Amusic van chua duoc dang ky. De dang ky lai soan DK %s gui toi 9166. Chi tiet lien he 900 (200d/phut). Tran trong cam on!',
        ),
        'subcsriber_wap'=>array(
            'balance_too_low' => 'Tài khoản của bạn không đủ tiền để đăng ký dịch vụ Amusic, vui lòng nạp thêm tiền để sử dụng dịch vụ. Xin cảm ơn!',
            'balance_too_low_a1' => 'Tài khoản của Quý khách không đủ tiền để đăng ký gói ngày A1 (2000đ/ngày). Mời Quý khách nạp thêm tiền vào tài khoản và đăng ký để sử dụng dịch vụ.',
            'balance_too_low_a7' => 'Tài khoản của Quý khách không đủ tiền để đăng ký gói tuần A7 (7000đ/tuần). Mời Quý khách nạp thêm tiền vào tài khoản và đăng ký để sử dụng dịch vụ.',
            'balance_too_low_a7' => 'Tài khoản của Quý khách không đủ tiền để đăng ký gói tháng A7 (30000đ/tháng). Mời Quý khách nạp thêm tiền vào tài khoản và đăng ký để sử dụng dịch vụ.',
            'duplicate_package_a1'=>'Quý khách đang sử dụng gói A1. Vui lòng hủy gói đang sử dụng trước.',
            'duplicate_package_a7'=>'Quý khách đang sử dụng gói A7. Vui lòng hủy gói đang sử dụng trước.',
            'duplicate_package_a30'=>'Quý khách đang sử dụng gói A30. Vui lòng hủy gói đang sử dụng trước.',

        ),
        'subscribe_msg'=>array(
            'success'=>'Quý khách đã đăng ký thành công gói Tengoi. Quý khách được hoàn toàn Miễn cước 3G/GPRS khi sử dụng điện thoại xem các clip ca nhạc HOT nhất tại gói âm nhạc của MobiFone.',
            'unsuccess'=>'Tài khoản của Quý khách không đủ để đăng ký gói [Tengoi]. Vui lòng nạp thêm tiền vào đăng ký.',
            'success_km_a1'=>'Quý khách đã đăng ký thành công gói A1. Quý khách được Miễn phí 05 ngày nghe xem tải không giới hạn các bài hát và Clip ca nhạc HOT nhất hiện nay. Đặc biệt, dịch vụ hoàn toàn Miễn cước 3G/GPRS.',
            'success_km_a7'=>'Quý khách đã đăng ký thành công gói A7. Quý khách được Miễn phí 05 ngày nghe xem tải không giới hạn các bài hát và Clip ca nhạc HOT nhất hiện nay. Đặc biệt, dịch vụ hoàn toàn Miễn cước 3G/GPRS.',
            'success_km_a30'=>'Quý khách đã đăng ký thành công gói A30. Quý khách được Miễn phí 07 ngày nghe xem tải không giới hạn các bài hát và Clip ca nhạc HOT nhất hiện nay. Đặc biệt, dịch vụ hoàn toàn Miễn cước 3G/GPRS.',
            'success_a1'=>'Quý khách đã đăng ký thành công gói A1. Quý khách được nghe xem tải không giới hạn các bài hát, Clip ca nhạc HOT nhất hiện nay. Đặc biệt, dịch vụ hoàn toàn Miễn cước 3G/GPRS',
            'success_a7'=>'Quý khách đã đăng ký thành công gói A7. Quý khách được nghe xem tải không giới hạn các bài hát, Clip ca nhạc HOT nhất hiện nay. Đặc biệt, dịch vụ hoàn toàn Miễn cước 3G/GPRS',
            'success_a30'=>'Quý khách đã đăng ký thành công gói A30. Quý khách được nghe xem tải không giới hạn các bài hát, Clip ca nhạc HOT nhất hiện nay. Đặc biệt, dịch vụ hoàn toàn Miễn cước 3G/GPRS',
            'is_not_mobifone_number'=>'Số điện thoại của bạn phải là thuê bao của Mobifone mới có thể đăng ký được gói cước.',
            'balance_too_low' => 'Tài khoản của Quý khách không đủ để đăng ký gói [Tengoi]. Vui lòng nạp thêm tiền vào đăng ký.',
            'balance_too_low_a1' => 'Tài khoản của Quý khách không đủ tiền để đăng ký gói ngày A1 (2000đ/ngày). Mời Quý khách nạp thêm tiền vào tài khoản và đăng ký để sử dụng dịch vụ.',
            'balance_too_low_a7' => 'Tài khoản của Quý khách không đủ tiền để đăng ký gói tuần A7 (7000đ/tuần). Mời Quý khách nạp thêm tiền vào tài khoản và đăng ký để sử dụng dịch vụ.',
            'balance_too_low_a30' => 'Tài khoản của Quý khách không đủ tiền để đăng ký gói tuần A30 (30000đ/tháng). Mời Quý khách nạp thêm tiền vào tài khoản và đăng ký để sử dụng dịch vụ.',
            'duplicate_package_a1'=>'Quý khách đang sử dụng gói A1. Vui lòng hủy gói cước đang sử dụng để đăng ký gói cước khác.',
            'duplicate_package_a7'=>'Quý khách đang sử dụng gói A7. Vui lòng hủy gói cước đang sử dụng để đăng ký gói cước khác.',
            'duplicate_package_a30'=>'Quý khách đang sử dụng gói A30. Vui lòng hủy gói cước đang sử dụng để đăng ký gói cước khác.',
            'default'=>'Hệ thống tạm thời có lỗi, Quý khách vui lòng thử lại sau ít phút. Trân trọng cảm ơn!',
            'blacklist_phone'=>'Quý khách đăng ký không thành công do số điện thoại của Quý Khách thuộc danh sách từ chối dịch vụ GTGT của MobiFone. Để được sử dụng dịch vụ miễn phí: Data (4G/3G/GPRS) khi nghe/xem/tải Clip ca nhac. Quý khách vui lòng liên hệ: 9090 để được hỗ trợ.',
        ),
        'subscribe_ext' => array(
            'success_am7' => '(GH) Goi cuoc A7 dich vu Amusic cua Quy khach vua duoc gia han voi 7.000d/tuan den :EXPIRED. Truy cap http://amusic.vn de nghe, xem cac bai hat, MV dac sac nhat hien nay. Dich vu hoan toan mien phi cuoc GPRS/3G. Neu khong muon tiep tuc su dung, soan Huy Tengoi gui 9166 de huy dich vu. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'msg' => 'Dich vu Amusic cua MobiFone kinh moi Quy khach truy cap http://amusic.vn  de xem MIEN PHI cac bai hat, MV dac sac nhat hien nay. Dac biet dich vu mien phi hoan toan cuoc GPRS/3G. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'welcome_a7'=>'Dich vu Amusic cua MobiFone kinh moi Quy khach truy cap http://amusic.vn  de xem MIEN PHI cac bai hat, MV dac sac nhat hien nay. Dac biet dich vu mien phi hoan toan cuoc GPRS/3G. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'success_a30'=>'Goi cuoc A30 dich vu Amusic cua Quy khach vua duoc gia han voi 30.000d/thang den :EXPIRED. Truy cap http://amusic.vn de nghe, xem cac bai hat, MV dac sac nhat hien nay. Dich vu hoan toan mien phi cuoc GPRS/3G. Neu khong muon tiep tuc su dung, soan Huy Tengoi gui 9166 de huy dich vu. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'msg_a30'=>'Dich vu Amusic cua MobiFone kinh moi Quy khach truy cap http://amusic.vn de xem MIEN PHI cac bai hat, MV dac sac nhat hien nay. Dac biet dich vu mien phi hoan toan cuoc GPRS/3G. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
        ),
        'unsubscribe' => array(
            'success_a1' => 'Quy khach da huy thanh cong goi A1 dich vu Amusic. De dang ky lai, soan "DK Tengoi" gui 9166 (Tengoi: A1 - goi ngay, A7 - goi tuan) hoac truy cap http://amusic.vn de nghe va xem cac clip ca nhac dac sac nhat hien nay (mien cuoc GPRS/3G). Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'success_a7' => 'Quy khach da huy thanh cong goi A7 dich vu Amusic. De dang ky lai, soan "DK Tengoi" gui 9166 (Tengoi: A1 - goi ngay, A7 - goi tuan) hoac truy cap http://amusic.vn de nghe va xem cac clip ca nhac dac sac nhat hien nay (mien cuoc GPRS/3G). Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'success_a30' => 'Quy khach da huy thanh cong goi A30 dich vu Amusic. De dang ky lai, soan “DK Tengoi” gui 9166 (Tengoi: A1 - goi ngay, A7 - goi tuan, A30 - goi thang) hoac truy cap http://amusic.vn de nghe va xem cac clip ca nhac dac sac nhat hien nay (mien cuoc GPRS/3G). Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'subscribe_user_not_exist' => 'Yeu cau huy dich vu khong thanh cong do Quy khach chua dang ky goi dich vu. Soan "DK Tengoi" gui 9166 (Tengoi: A1 - goi ngay, A7 - goi tuan) de dang ky su dung dich vu Amusic cua MobiFone hoac truy cap http://amusic.vn de nghe xem tai cac bai hat va clip HOT nhat hien nay (mien cuoc GPRS/3G). Chi tiet goi 9090 (200d/phut). Tran trong cam on!',
            'error_default' => "Co loi trong qua trinh huy goi cuoc, vui long thu lại sau!",
//            'auto_unsub' => "Thoi han su dung dich vu nghe bai hat, xem clip ca nhac MIEN PHI cua khach hang da het han su dung. De dang ky lai su dung dich vu nghe nhac va xem video khong gioi han Quy khach vui long soan: DK Ten goi gui 9022 (Ten goi: AM hoac AM7) hoac goi 9090 de biet them chi tiet. Tran trong cam on!",
            'auto_unsub' => 'Xin loi, Goi :PACKAGE dich vu Amusic da bi huy do tai khoan cua quy khach khong du tien de tiep tuc su dung. Vui long nap them tien de tiep tuc su dung. De dang ky lai, soan "DK Tengoi" gui 9166 (Tengoi: A1, A7) Truy cap http://amusic.vn hoac goi 9090 (200d/phut) de biet them chi tiet. Tran trong cam on',
            'success_a1_msg'=>'Qúy Khách đã hủy thành công gói cước của dịch vụ Amusic. Để đăng ký lại dịch vụ, Quý Khách vui lòng soạn "DK Tengoi" gửi 9166 (Tên gói A1, A7) để đăng ký sử dụng dịch vụ nghe bài hát và xem clip ca nhạc không giới hạn của MobiFone. Truy cập http://amusic.vn để bắt đầu sử dụng dịch vụ (hoàn toàn miễn cước GPRS/3G). Chi tiết gọi 9090. Trân trọng cảm ơn!',
            'success_a7_msg'=>'Qúy Khách đã hủy thành công gói cước của dịch vụ Amusic. Để đăng ký lại dịch vụ, Quý Khách vui lòng soạn "DK Tengoi" gửi 9166 (Tên gói A1, A7) để đăng ký sử dụng dịch vụ nghe bài hát và xem clip ca nhạc không giới hạn của MobiFone. Truy cập http://amusic.vn để bắt đầu sử dụng dịch vụ (hoàn toàn miễn cước GPRS/3G). Chi tiết gọi 9090. Trân trọng cảm ơn!',
            'subscribe_user_not_exist_msg' => 'Bạn chưa đăng ký gói cước. De dang ky, soan "DK Tengoi" gui 9166 (Tengoi: A1, A7) hoac  truy cap http://amusic.vn de nghe, xem, tai cac clip ca nhac dac sac nhat hien nay (mien cuoc GPRS/3G).',

        ),
        'unsubscribe_msg' => array(
            'error_default' => "Co loi trong qua trinh huy goi cuoc, vui long thu lại sau!",
            'auto_unsub' => "Thoi han su dung dich vu nghe bai hat, xem clip ca nhac MIEN PHI cua khach hang da het han su dung. De dang ky lai su dung dich vu nghe nhac va xem video khong gioi han Quy khach vui long soan: DK Ten goi gui 9022 (Ten goi: AM hoac AM7) hoac goi 9090 de biet them chi tiet. Tran trong cam on!",
            'success_a1'=>'Quý khách đã hủy thành công gói cước của dịch vụ Amusic. Mời Quý khách đăng ký lại khi có nhu cầu nghe xem tải các bài hát, video ĐỘC QUYỀN và chất lượng cao nhất trên Amusic.',
            'success_a7'=>'Quý khách đã hủy thành công gói cước của dịch vụ Amusic. Mời Quý khách đăng ký lại khi có nhu cầu nghe xem tải các bài hát, video ĐỘC QUYỀN và chất lượng cao nhất trên Amusic.',
            'success_a30'=>'Quy khach da huy thanh cong goi A30 dich vu Amusic. De dang ky lai, soan “DK Tengoi” gui 9166 (Tengoi: A1 – goi ngay, A7 – goi tuan, A30 – goi thang) hoac truy cap http://amusic.vn de nghe va xem cac clip ca nhac dac sac nhat hien nay (mien cuoc GPRS/3G). Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'subscribe_user_not_exist' => 'Yêu cầu hủy dịch vụ không thành công do Quý khách chưa đăng ký gói dịch vụ. Soạn "DK Tengoi" gửi 9166 (Tengoi: A1 - gói ngày, A7 - goi tuần) để đăng ký sử dụng dịch vụ Amusic của Mobifone hoặc truy cập http://Amusic.vn để nghe xem tải các bài hát va clip HOT nhất hiện nay (mien cuoc GPRS/3G). Chi tiết gọi 9090, trân trọng cảm ơn!',
            'success_a1_msg'=>'Quý khách đã hủy thành công gói cước của dịch vụ Amusic. Mời Quý khách đăng ký lại khi có nhu cầu nghe xem tải các bài hát, video ĐỘC QUYỀN và chất lượng cao nhất trên Amusic.',
            'success_a7_msg'=>'Quý khách đã hủy thành công gói cước của dịch vụ Amusic. Mời Quý khách đăng ký lại khi có nhu cầu nghe xem tải các bài hát, video ĐỘC QUYỀN và chất lượng cao nhất trên Amusic.',
            'success_a30_msg'=>'Quý khách đã hủy thành công gói cước của dịch vụ Amusic. Mời Quý khách đăng ký lại khi có nhu cầu nghe xem tải các bài hát, video ĐỘC QUYỀN và chất lượng cao nhất trên Amusic.',
            'subscribe_user_not_exist_msg' => 'Bạn chưa đăng ký gói cước. De dang ky, soan "DK Tengoi" gui 9166 (Tengoi: A1, A7) hoac  truy cap http://amusic.vn de nghe, xem, tai cac clip ca nhac dac sac nhat hien nay (mien cuoc GPRS/3G).',



        ),
        'subscribe_ext_notify' => array(
            'a1' => 'Quy khach chi con 02 ngay su dung MIEN PHI goi A1 tren Amusic, goi cuoc se tu dong gia han voi muc cuoc 2.000/ngay tu ngay :EXPIRED_TIME. Truy cap dich vu tai http://amusic.vn de tham gia cac su kien hap dan chi co tren dich vu Amusic. Neu khong muon tiep tuc su dung dich vu, soan HUY A1 gui 9166. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'a7' => 'Quy khach chi con 02 ngay su dung MIEN PHI goi A7 tren Amusic, goi cuoc se tu dong gia han voi muc cuoc 7.000/tuan tu ngay :EXPIRED_TIME. Truy cap dich vu tai http://amusic.vn de tham gia cac su kien hap dan chi co tren dich vu Amusic. Neu khong muon tiep tuc su dung dich vu, soan HUY A7 gui 9166. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
        ),
        'sms_help' => "De nghe xem tai cac bai hat, MV dac sac DOC QUYEN tai Amusic va mien cuoc 3G/GPRS khi su dung, soan DK Tengoi gui 9166 (Tengoi: A1 - 2000d/ngay, A7 - 7000d/ tuan). De kiem tra goi cuoc soan KT gui 9166. De biet gia cuoc soan GIA gui 9166. De huy soan HUY Tengoi gui 9166 hoac truy cap http://amusic.vn de biet them chi tiet. Chi tiet goi 9090 (200d/phut). Tran trong cam on!",
        'wrongSms' => 'Quy khach vua nhap cu phap chua dung. De xem Clip HOT soan DK MC1 gui 9022. De xem PHIM soan DK PHIM gui 9022. De xem Clip thoi trang lam dep soan DK STV gửi 9022. De xem Clip hai huoc soan DK HAI gui 9022. De xem Clip Am nhac soan DK AM gui 9022. De kiem tra goi cuoc soan KT gui 9022. De biet gia cuoc soan GIA gui 9022. De huy soan HUY Tengoi gui 9022 hoac truy cap http://mobiclip.vn/music de biet them chi tiet.',
        'smsWSDL' => 'http://10.1.10.67:8080/api/soap',
        'error_limit' => 'Quý khách đã nghe(xem) hết 5 lượt nội dung miễn phí trong ngày. Để được nghe, xem, tải nội dung miễn phí không giới hạn số lượng, miễn cước data, vui lòng đăng nhập',
        'content_download' => 'Phí tải :CONTENT này là :PRICE đ. Quý khách có thật sự muốn tải không?',
        'content_play' => "Bạn có muốn nghe bài hát :NAME với giá :PRICE đ?",
        'content_download_request' => 'Qúy khách vui lòng đăng ký để được tải nội dung miễn phí hoặc tiếp tục tải nội dung này với giá :PRICE đ.',
        'confirm_unreg'=>'Bạn đang sử dụng gói cước {:PACKAGE} có thời hạn đến {:DATE}. Bạn có muốn hủy gói cước không?',
        'price'=>array(
            'show_price'=>'Cuoc DV Amusic: A1 - 2.000d/ngay (mien phi dang ky lan dau), A7 -  7.000d/tuan (mien phi dang ky lan dau). Chi tiet truy cap http://amusic.vn hoac goi 9090 (200d/phut). Tran trong cam on!',
        ),
        'sms.messageMT' => array(
            'error_syntax' => 'Xin loi, Quy khach vua nhap sai cu phap. De nghe xem tai bai hat va cac clip ca nhac HOT nhat hien nay soan DK Tengoi gui 9166 (Tengoi: A1 - goi ngay, A7 - goi tuan). De kiem tra goi cuoc, soan KT gui 9166. De biet gia, soan GIA gui 9166, de huy soan HUY Tengoi gui 9166. Truy cap http://amusic.vn hoac goi 9090 (200d/phut) de biet them chi tiet. Tran trong cam on!',
        ),
        'sms_tc'=>array(
            'sms_tc_am1'=>'Quy khach da tu choi nhan cac ban tin thong bao noi dung dinh ky cua goi cuoc A1 dich vu Amusic. De dang ky lai, vui long soan DK SMS A1 gui 9166. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'sms_tc_am7'=>'Quy khach da tu choi nhan cac ban tin thong bao noi dung dinh ky cua goi cuoc A7 dich vu Amusic. De dang ky lai, vui long soan DK SMS A7 gui 9166. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',

        ),
        'sms_dk'=>array(
            'sms_dk_a1'=>'Quy khach da dang ky nhan cac ban tin thong bao noi dung dinh ky cua goi cuoc A1 dich vu Amusic. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'sms_dk_a7'=>'Quy khach da dang ky nhan cac ban tin thong bao noi dung dinh ky cua goi cuoc A7 dich vu Amusic. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!'
        ),

        /*'ctkm_sms'=>array(
            'subscribe_firstime'=>'Chuc mung, Quy khach da nhan duoc :POINT diem tich luy CTKM “NGHE NHAC HAY -  TRUNG NGAY HONDA LEAD”. Tu nay den het 29/11/2015, tiep tuc nghe xem noi dung tren Amusic de co co hoi nhan ngay 1 xe Honda Lead va nhung phan qua gia tri khac. Tra cuu diem thuong tai http://amusic.vn/ctkm/tracuu. Chi tiet LH 9090 (200d/p). Chuc Quy khach may man!',
            'tich_luy_diem'=>'Diem tich luy CTKM “NGHE NHAC HAY -  TRUNG NGAY HONDA LEAD” cua Quy khach hien tai la: :POINT. Moi Quy khach truy cap http://amusic.vn de tiep tuc tham gia tich diem va co co hoi nhan ngay 1 xe Honda Lead va nhieu phan qua hap dan khac. Tra cuu diem thuong tai http://amusic.vn/ctkm/tracuu. Chi tiet LH 9090 (200d/p). Chuc Quy khach may man!',
        ),*/
        'ctkm_sms'=>array(
            'subscribe_firstime'=>'Chuc mung, Quy khach da nhan duoc :POINT diem tich luy CTKM “Nghe nhac hay -  Trung qua ngay”. Tu nay den het 26/10/2016, tiep tuc nghe xem noi dung tren Amusic de co co hoi nhan Dien thoai Samsung Galaxy S7 hang thang va nhung phan qua gia tri khac. Tra cuu diem thuong tai http://amusic.vn/ctkm/tracuu . Chi tiet LH 9090 (200đ/phut). Chuc Quy khach may man”',
            'tich_luy_diem'=>'Diem tich luy CTKM “ Nghe nhac hay -  Trung qua ngay” cua Quy khach hien tai la: :POINT. Moi Quy khach truy cap http://amusic.vn de tiep tuc tham gia tich diem de co co hoi nhan ngay dien thoai Samsung Galaxy S7 hang thang va nhieu phan qua hap dan khac. Tra cuu diem thuong tai http://amusic.vn/ctkm/tracuu . Chi tiet LH: 9090 (200d/phut). Chuc Quy khach may man!',
            'sms_unsubcribe'=>'Diem tich luy CTKM “ Nghe nhac hay -  Trung qua ngay” cua Quy khach hien tai la: :POINT. Quy khach co co hoi trung dien thoai Samsung Galaxy S7 hang thang neu tiep tuc dang ky dich vu. Moi Quy khach truy cap http://amusic.vn de nghe nhac hoan toan MIEN PHI 3G. Tra cuu diem thuong tai http://amusic.vn/ctkm/tracuu . Chi tiet LH: 9090 (200d/phut). Chuc Quy khach may man!'
        ),
        'blacklist' =>array(
            'content'=>'Yeu cau dang ky khong thanh cong do so dien thoai cua Quy khach thuoc danh sach tu choi dang ky dich vu GTGT cua MobiFone. De dang ky dich vu Quy khach vui long lien he: 9090 (200d/phut). Tran trong cam on!',
        ),
    )
);
?>