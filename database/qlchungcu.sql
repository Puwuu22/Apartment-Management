CREATE DATABASE QLCHUNGCU;
USE QLCHUNGCU;

													-- TẠO BẢNG --
CREATE TABLE NhanVien (
    MaNV CHAR(6) NOT NULL,
    TenNV VARCHAR(30) NOT NULL,
    GioiTinh VARCHAR(4),
    SDT VARCHAR(10) UNIQUE,
    DiaChi VARCHAR(255) NOT NULL,
    NgSinh DATE NOT NULL,
    NgVL DATE NOT NULL,
    LoaiNV VARCHAR(10) NOT NULL,
    MatKhau VARCHAR(255),
    PRIMARY KEY (MaNV)
);

-- Tạo bảng DichVu
CREATE TABLE DichVu (
    MaDV CHAR(6) NOT NULL,
    TenDV VARCHAR(255) NOT NULL,
    PhiDV DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (MaDV)
);

-- Tạo bảng PhuTrach
CREATE TABLE PhuTrach (
    MaHD CHAR(6) NOT NULL,
    MaNV CHAR(6) NOT NULL,
    PRIMARY KEY (MaHD, MaNV)
);

-- Tạo bảng HoaDon
CREATE TABLE HoaDon (
	MaHD CHAR(5) NOT NULL,
    TenHD VARCHAR(30) NOT NULL,
    NgHD DATETIME NOT NULL,
    PhiPS DECIMAL(10, 2),
    TriGia DECIMAL(10, 2),
    TinhTrang INT NOT NULL,
    GhiChu TEXT,
    MaDV CHAR(6) NOT NULL,
    MaCH CHAR(6) NOT NULL,
    PRIMARY KEY (MaHD)
);

-- Tạo bảng CuDan
CREATE TABLE CuDan (
    MaCD CHAR(6) NOT NULL,
    TenCD VARCHAR(30) NOT NULL,
    GioiTinh VARCHAR(4) NOT NULL,
    SDT VARCHAR(10) UNIQUE,
    NgSinh DATE NOT NULL,
    QueQuan VARCHAR(30) NOT NULL,
    MaCH CHAR(6) NOT NULL,
    NgVaoO DATE,
    MatKhau VARCHAR(255),
    PRIMARY KEY (MaCD)
);

-- Tạo bảng CanHo
CREATE TABLE CanHo (
    MaCH CHAR(6) NOT NULL,
    LoaiCH VARCHAR(10) NOT NULL,
    MoTa TEXT,
    DienTich DECIMAL(5, 2) NOT NULL,
    Gia DECIMAL(14, 2) NOT NULL,
    MaTang CHAR(7) NOT NULL,
    TinhTrang INT NOT NULL,
    ChuHo CHAR(6),
    PRIMARY KEY (MaCH)
);

-- Tạo bảng Tang
CREATE TABLE Tang (
    MaTang CHAR(5) NOT NULL,
    TenTang VARCHAR(10) NOT NULL,
    SoCH INT NOT NULL,
    MaToa CHAR(6) NOT NULL,
    PRIMARY KEY (MaTang)
);

-- Tạo bảng Toa
CREATE TABLE Toa (
    MaToa CHAR(6) NOT NULL,
    TenToa VARCHAR(10) NOT NULL,
    SoTang INT NOT NULL,
	MoTa TEXT,
    PRIMARY KEY (MaToa)
);

-- Tạo bảng ThietBi
CREATE TABLE ThietBi (
    MaTBi CHAR(6) NOT NULL,
    TenTBi VARCHAR(30) NOT NULL,
    SL INT NOT NULL,
    PRIMARY KEY (MaTBi) 
);

-- Tạo bảng BoTri
CREATE TABLE BoTri (
    MaTBi CHAR(6) NOT NULL,
    MaTang CHAR(5) NOT NULL,
    SL INT NOT NULL,
    PRIMARY KEY (MaTBi, MaTang)
);

-- Tạo bảng ThongBao
CREATE TABLE ThongBao (
    MaTB CHAR(6) NOT NULL,
    LoaiTB VARCHAR(30) NOT NULL,
	TieuDe VARCHAR(255) NOT NULL,
    NoiDung TEXT NOT NULL,
	NgTB DATETIME NOT NULL,
    PRIMARY KEY (MaTB)
);

-- Tạo bảng TB_CD
CREATE TABLE TB_CD (
    MaTB CHAR(6) NOT NULL,
    MaCD CHAR(6) NOT NULL,
    PRIMARY KEY (MaTB , MaCD)
);

CREATE TABLE PhanAnh (
	MaPA CHAR(6) NOT NULL,
    LoaiPA VARCHAR(20) NOT NULL,
	TieuDe VARCHAR(255) NOT NULL,
	NoiDung TEXT NOT NULL,
    NgPA DATETIME NOT NULL,
    TinhTrang INT NOT NULL,
    MaCD CHAR(6) NOT NULL,
    PRIMARY KEY (MaPA, MaCD)
);

                      -- TẠO KHÓA NGOẠI --

-- Thêm khóa ngoại cho bảng PhuTrach
ALTER TABLE PhuTrach
ADD CONSTRAINT FK_PT_MANV FOREIGN KEY (MaNV) REFERENCES NhanVien(MaNV),
ADD CONSTRAINT FK_PT_MAHD FOREIGN KEY (MaHD) REFERENCES HoaDon(MaHD);

-- Thêm khóa ngoại cho bảng HoaDon
ALTER TABLE HoaDon
ADD CONSTRAINT FK_HD_MACH FOREIGN KEY (MaCH) REFERENCES CanHo(MaCH),
ADD CONSTRAINT FK_HD_MADV FOREIGN KEY (MaDV) REFERENCES DichVu(MaDV);

-- Thêm khóa ngoại cho bảng CuDan
ALTER TABLE CuDan
ADD CONSTRAINT FK_CD_MACH FOREIGN KEY (MaCH) REFERENCES CanHo(MaCH);

-- Thêm khóa ngoại cho bảng CanHo
ALTER TABLE CanHo
ADD CONSTRAINT FK_CANHO_MATANG FOREIGN KEY (MaTang) REFERENCES Tang(MaTang),
ADD CONSTRAINT FK_CANHO_CHUHO FOREIGN KEY (ChuHo) REFERENCES CuDan(MaCD);

-- Thêm khóa ngoại cho bảng Tang
ALTER TABLE Tang
ADD CONSTRAINT FK_TANG_MATOA FOREIGN KEY (MaToa) REFERENCES Toa(MaToa);

-- Thêm khóa ngoại cho bảng BoTri
ALTER TABLE BoTri
ADD CONSTRAINT FK_BOTRI_MATBI FOREIGN KEY (MaTBi) REFERENCES ThietBi(MaTBi),
ADD CONSTRAINT FK_BOTRI_MATANG FOREIGN KEY (MaTang) REFERENCES Tang(MaTang);

-- Thêm khóa ngoại cho bảng TB_CD
ALTER TABLE TB_CD
ADD CONSTRAINT FK_TB_CD_MATB FOREIGN KEY (MaTB) REFERENCES ThongBao(MaTB),
ADD CONSTRAINT FK_TB_CD_MACD FOREIGN KEY (MaCD) REFERENCES CuDan(MaCD);

-- Thêm khóa ngoại cho bảng PhanAnh
ALTER TABLE PhanAnh
ADD CONSTRAINT FK_PhanAnh_MaCD FOREIGN KEY (MaCD) REFERENCES CuDan(MaCD);


															-- TẠO INDEX --

/*
Chỉ mục hoạt động hiệu quả trên các cột có tần suất truy cập cao ở các lệnh where hay join giúp các câu lệnh thực thi nhanh hơn.
*/
-- 1. Index trong bảng HoaDon
CREATE INDEX I_HoaDon_MaCH ON HoaDon(MaCH);
CREATE INDEX I_HoaDon_MaDV ON HoaDon(MaDV);

-- 2. Index trong bảng CanHo
CREATE INDEX I_CanHo_ChuHo ON CanHo(ChuHo);
CREATE INDEX I_CanHo_MaTang ON CanHo(MaTang);

-- 3. Index trong bảng CuDan
CREATE INDEX I_CuDan_MaCH ON CuDan(MaCH);

-- 4. Index trong bảng PhanAnh
CREATE INDEX I_PhanAnh_MaCD ON PhanAnh(MaCD);

-- 5. Index trong bảng Tang
CREATE INDEX I_Tang_MaToa ON Tang(MaToa);


														-- TẠO RÀNG BUỘC TOÀN VẸN--

-- 1. Giới tính của nhân viên chỉ có thể là 'Nam' hoặc 'Nữ'.
ALTER TABLE NhanVien
ADD CONSTRAINT CK_NV_GIOITINH CHECK (GioiTinh IN ('Nam', 'Nữ'));
-- 2. Loại nhân viên chỉ có thể là 'Bảo vệ', 'Lao công', 'Bảo trì', 'Quản lý', 'BQT', 'Kế toán', 'Tư vấn'
 ALTER TABLE NhanVien
 ADD CONSTRAINT CK_NV_LOAINV CHECK (LoaiNV IN ('Bảo vệ', 'Lao công', 'Bảo trì', 'Quản lý', 'BQT', 'Kế toán', 'Tư vấn'));
-- 3. Tình trạng chỉ có thể là 1 (Chưa thanh toán), 2 (Đã thanh toán).
ALTER TABLE HoaDon
ADD CONSTRAINT CK_HD_TINHTRANG CHECK (TinhTrang IN ('1', '2'));
-- 4. Tổng giá trị của hóa đơn không được nhỏ hơn 0.
ALTER TABLE HoaDon
ADD CONSTRAINT CK_HD_TRIGIA CHECK (TriGia >= 0); 
-- 5. Giới tính cư dân chỉ có thể là 'Nam' hoặc 'Nữ'.
ALTER TABLE CuDan
ADD CONSTRAINT CK_CD_GIOITINH CHECK (GioiTinh IN ('Nam', 'Nữ'));
-- 6. Diện tích phải lớn hơn 0.
ALTER TABLE CanHo
ADD CONSTRAINT CK_CH_DIENTICH CHECK (DienTich > 0);
-- 7. Tình trạng chỉ có thể là 1 (Trống), 2 (Đang sử dụng).
ALTER TABLE CanHo
ADD CONSTRAINT CK_CH_TINHTRANG CHECK (TinhTrang IN ('1', '2'));
-- 8. Giá thuê phải lớn hơn 0.
ALTER TABLE CanHo
ADD CONSTRAINT CK_CH_GIA CHECK (Gia > 0);
-- 9. Phí dịch vụ không được nhỏ hơn 0.
ALTER TABLE DichVu
ADD CONSTRAINT CK_DV_PHIDV CHECK (PhiDV >= 0);
-- 10. Chi phí phát sinh không thể nhỏ hơn 0.
ALTER TABLE HoaDon
ADD CONSTRAINT CK_HD_PHIPS CHECK (PhiPS >= 0);
-- 11. Số tầng phải lớn hơn 0.
ALTER TABLE Toa
ADD CONSTRAINT CK_TOA_SOTANG CHECK (SoTang > 0);
-- 12. Tình trạng của phản ánh chỉ có thể là 1 (Mới), 2 (Đang xử lý), 3 (Hoàn thành).
ALTER TABLE PhanAnh
ADD CONSTRAINT CK_PA_TINHTRANG CHECK (TinhTrang IN (1, 2, 3));


														-- TẠO TRIGGER -- 

-- 1. Kiểm tra quyền hạn phụ trách của nhân viên.
DELIMITER //
CREATE TRIGGER TRG_KT_QuyenHan_NVPT
BEFORE INSERT ON PhuTrach
FOR EACH ROW
BEGIN
    DECLARE loaiNV VARCHAR(10);
    DECLARE maDV CHAR(6);

    SELECT LoaiNV INTO loaiNV
    FROM NhanVien
    WHERE MaNV = NEW.MaNV;
    
    SELECT MaDV INTO maDV
    FROM HoaDon HD
    WHERE MaHD = NEW.MaHD;

    IF (loaiNV = 'Lao công' AND maDV NOT IN ('DV01')) OR
	   (loaiNV = 'Bảo vệ' AND maDV NOT IN ('DV04', 'DV05')) OR 
       (loaiNV = 'Bảo trì' AND maDV NOT IN ('DV02', 'DV03')) OR 
       (loaiNV = 'Quản lý' AND maDV NOT IN ('DV06', 'DV07')) THEN 
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Nhân viên không được phân công đúng nhiệm vụ!';
    END IF;
END//

DELIMITER ;

-- 2. Tự động cập nhật trị giá của hóa đơn.

-- Khi sửa 1 hóa đơn
DELIMITER //
CREATE TRIGGER TRG_HoaDon_UP
BEFORE UPDATE ON HoaDon
FOR EACH ROW
BEGIN
    -- Tính TriGia = PhiPS + (SELECT PhiDV FROM DichVu WHERE MaDV = NEW.MaDV)
    SET NEW.TriGia = NEW.PhiPS + (SELECT PhiDV FROM DichVu WHERE MaDV = NEW.MaDV);
END //
DELIMITER ;

-- Khi thêm 1 hóa đơn.
DELIMITER //
CREATE TRIGGER TRG_HoaDon_IN
BEFORE INSERT ON HoaDon
FOR EACH ROW
BEGIN
    -- Tính TriGia = PhiPS + (SELECT PhiDV FROM DichVu WHERE MaDV = NEW.MaDV)
    SET NEW.TriGia = NEW.PhiPS + (SELECT PhiDV FROM DichVu WHERE MaDV = NEW.MaDV);
END //
DELIMITER ;

-- Khi Update PhiDV
DELIMITER // 
CREATE TRIGGER TRG_DichVu_UP
AFTER UPDATE ON DichVu
FOR EACH ROW
BEGIN
    -- Cập nhật TriGia cho tất cả các hóa đơn có MaDV bị thay đổi
    UPDATE HoaDon
    SET TriGia = PhiPS + NEW.PhiDV
    WHERE MaDV = NEW.MaDV;
END //
DELIMITER ;

-- 3. Xóa một cư dân sẽ xóa các thông tin liên quan đến cư dân đó.
DELIMITER //
CREATE TRIGGER TRG_Xoa_CD 
BEFORE DELETE ON CUDAN
FOR EACH ROW
BEGIN
    DECLARE v_MaCD CHAR(6);
    SET v_MaCD = OLD.MaCD;
    DELETE FROM TB_CD WHERE MaCD = v_MaCD;
    DELETE FROM PhanAnh WHERE MaCD = v_MaCD;
    UPDATE CanHo SET ChuHo = NULL WHERE ChuHo = v_MaCD;
END //
DELIMITER ;

-- 4. Cập nhật trạng thái căn hộ khi có người chuyển đến.
DELIMITER //
CREATE TRIGGER TRG_TTCanHo_UP
AFTER INSERT ON CuDan
FOR EACH ROW
BEGIN
	UPDATE CanHo
	SET TinhTrang = 2 -- Cập nhật trạng thái căn hộ sang "Đang có người sử dụng"
	WHERE MaCH = (SELECT MaCH FROM CuDan WHERE MaCD = New.MaCD);
END //
DELIMITER ;

-- 5. Tự động cập nhật số lượng thiết bị trong kho khi có thiết bị được lắp đặt
-- Khi thêm
DELIMITER //
CREATE TRIGGER TRG_SLTbi_IN
AFTER INSERT ON BoTri
FOR EACH ROW
BEGIN
  UPDATE ThietBi
  SET SL = SL - NEW.SL
  WHERE MaTBi = (SELECT DISTINCT MaTBi FROM BoTri WHERE MaTBi = NEW.MaTBi);
END //
DELIMITER ;

-- Khi sửa
DELIMITER //
CREATE TRIGGER TRG_SLTbi_UP
AFTER UPDATE ON BoTri
FOR EACH ROW
BEGIN
  UPDATE ThietBi
  SET SL = SL - (NEW.SL - OLD.SL)
  WHERE MaTBi = (SELECT DISTINCT MaTBi FROM BoTri WHERE MaTBi = NEW.MaTBi);
END //
DELIMITER ;

-- Khi xóa
DELIMITER //
CREATE TRIGGER TRG_SLTbi_DE
AFTER DELETE ON BoTri
FOR EACH ROW
BEGIN
  UPDATE ThietBi
  SET SL = SL + OLD.SL
  WHERE MaTBi = (SELECT DISTINCT MaTBi FROM BoTri WHERE MaTBi = OLD.MaTBi);
END // 
DELIMITER ;

-- 6. Giới hạn số lượng người ở trong một căn hộ 
DELIMITER //
CREATE TRIGGER TRG_GioiHan_CanHo
BEFORE INSERT ON CuDan
FOR EACH ROW
BEGIN
    DECLARE v_LoaiCH VARCHAR(10);
    DECLARE v_SoThanhVien INT;
    DECLARE v_SoThanhVien_Moi INT;

    -- Lấy loại căn hộ
    SELECT LoaiCH INTO v_LoaiCH FROM CanHo WHERE MaCH = NEW.MaCH;

    -- Lấy số thành viên hiện tại (nếu cập nhật)
    IF NEW.MaCD IS NOT NULL THEN
        SELECT COUNT(*) INTO v_SoThanhVien FROM CuDan WHERE MaCH = NEW.MaCH;
    ELSE
        SET v_SoThanhVien = 0;
    END IF;

    -- Tính toán số thành viên mới
    SET v_SoThanhVien_Moi = v_SoThanhVien + 1;

    -- Kiểm tra giới hạn dựa trên loại căn hộ
    IF (v_LoaiCH = 'Basic 1' AND v_SoThanhVien_Moi > 2) OR
	(v_LoaiCH = 'Basic 2' AND v_SoThanhVien_Moi > 4) OR
	(v_LoaiCH = 'Basic 3' AND v_SoThanhVien_Moi > 6) OR
	(v_LoaiCH = 'Basic 4' AND v_SoThanhVien_Moi > 8) THEN
	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Căn hộ vượt quá số thành viên quy định!';
    END IF;
END //


                                                              -- CÀI ĐẶT THỦ TỤC LƯU TRỮ --
 
 -- 1. In ra danh sách cư dân của chung cư. 
DELIMITER //
CREATE PROCEDURE SP_In_DS_Cudan()
BEGIN
    SELECT MaCD, TenCD, GioiTinh, SDT, NgSinh, QueQuan, MaCH, NgVaoO 
    FROM CuDan
    ORDER BY MaCD;
END //
DELIMITER ;

-- 2. In ra danh sách hóa đơn của một căn hộ
DELIMITER //
CREATE PROCEDURE  SP_In_DSHoadon_CanHo (p_MaCH CHAR(6))
BEGIN
    SELECT HD.*
    FROM HoaDon HD
    WHERE HD.MaCH = p_MaCH;
END //
DELIMITER ;

-- 3. In ra danh sách cư dân sống trong căn hộ. 
DELIMITER //
CREATE PROCEDURE  SP_In_DSCuDan_CanHo(p_MaCH CHAR(6))
BEGIN
	SELECT MaCH, TenCD, GioiTinh, SDT, NgSinh, QueQuan
	FROM CuDan CD
	WHERE CD.MaCH = p_MaCH;
END //
DELIMITER ;

-- 4. In danh sách nhân viên theo từng loại nhân viên. 
DELIMITER //
CREATE PROCEDURE  SP_In_DSNV_LoaiNV(p_LoaiNV VARCHAR(10))
BEGIN
	SELECT MaNV, TenNV, GioiTinh, NgSinh, SDT, DiaChi, NgVL, LoaiNV
	FROM NhanVien 
	WHERE LoaiNV = p_LoaiNV;
END //
DELIMITER ;

-- 5. In ra các căn hộ chưa thanh toán hóa đơn. 
DELIMITER //
CREATE PROCEDURE SP_In_DSCanHo_ChuaThanhToanHD()
BEGIN
	SELECT MaCH, MaHD, TriGia, TinhTrang 
	FROM HoaDon HD
	WHERE HD.TinhTrang = 1;
END //
DELIMITER ;

-- 6. Cập nhật thông tin căn hộ.                    
DELIMITER //
CREATE PROCEDURE SP_CapNhatTT_CanHo(MaCH INT, LoaiCH VARCHAR(10), MoTa TEXT, DienTich DECIMAL(5, 2), Gia DECIMAL(14, 2), ChuHo CHAR(6))
BEGIN
	UPDATE CanHo
	SET LoaiCH = LoaiCH,
    	MoTa = MoTa,
    	DienTich = DienTich,
    	Gia = Gia,
        ChuHo = ChuHo
	WHERE MaCH = MaCH;
END //
DELIMITER ;

-- 7. Tìm thông báo theo ngày. 
DELIMITER //
CREATE PROCEDURE SP_TimThongBao_Ngay (IN p_NgTB DATE)
BEGIN
    SELECT TB.*
    FROM ThongBao TB
    WHERE DATE(NgTB) = p_NgTB;
END //
DELIMITER ;

-- 8. Tìm tất cả thông tin của các cư dân theo mã cư dân . 
DELIMITER //
CREATE PROCEDURE SP_In_TTCuDan_MaCD(IN p_MaCD CHAR(6))
BEGIN
    SELECT MaCD, TenCD, GioiTinh, SDT, NgSinh, QueQuan, MaCH, NgVaoO 
    FROM CuDan
    WHERE MaCD = p_MaCD;
END //
DELIMITER ;

CALL SP_TTCuDan_MaCD('CD0001')


-- 9. Gửi thông báo cho tất cả các thành viên trong căn hộ
DELIMITER //

CREATE PROCEDURE SP_GuiThongBaoChoCanHo(IN p_MaTB CHAR(6), IN p_MaCH CHAR(6))
BEGIN
    INSERT INTO TB_CD (MaTB, MaCD)
    SELECT p_MaTB, MaCD
    FROM CuDan
    WHERE MaCH = p_MaCH;
END//

DELIMITER ;


-- 10. Gửi thông báo cho tất cả các căn hộ   
DELIMITER //
CREATE PROCEDURE SP_GuiThongBaoChoTatCaCanHo(IN p_MaTB CHAR(6))
BEGIN
    INSERT INTO TB_CD (MaTB, MaCD)
    SELECT p_MaTB, MaCD
    FROM CuDan;
END//

DELIMITER ;       

                                                                          
                                                              -- CÀI ĐẶT FUNCTION --
-- 1. Tính số căn hộ dựa trên mã tầng và loại căn hộ.
DELIMITER //
CREATE FUNCTION FT_SoCanHo(p_MaTang CHAR(7), p_LoaiCH VARCHAR(10))
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE SL INT;
    
    SELECT COUNT(MaCH) INTO SL
    FROM CanHo
    WHERE LoaiCH = p_LoaiCH AND MaTang=p_MaTang;
    
    RETURN SL;
END //
DELIMITER ;

-- Kiểm tra FT_SoCanHo
SELECT FT_SoCanHo('C05', 'Penthouse');

-- 2. Tính tổng số căn hộ trống của 1 tòa nhà
DELIMITER //
CREATE FUNCTION FT_SoPhongTrong(p_MaToa CHAR(6)) 
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE SL INT;
    
    SELECT COUNT(MaCH) INTO SL
    FROM CanHo CH 
    JOIN TANG ON CH.MaTang = TANG.MaTang
    JOIN TOA ON TANG.MaToa = TOA.MaToa
    WHERE TOA.MaToa = p_MaToa AND TinhTrang=1;
    RETURN SL;
END //
DELIMITER ;

-- Kiểm tra FT_SoPhongTrong
SELECT FT_SoPhongTrong('TOA002');

-- 3. Tính tổng số lượng cư dân của tòa nhà.  
DELIMITER //
CREATE FUNCTION FT_SLCuDan_Toa(p_MaToa CHAR(6)) 
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE SL INT;
    
    SELECT COUNT(distinct MaCD) INTO SL
    FROM CuDan CD, CanHo CH, Tang T
    WHERE T.MaToa = p_MaToa AND CD.MaCH = CH.MaCH AND CH.MaTang = T.MaTang;
    
    RETURN SL;
END //
DELIMITER ;

-- Kiểm tra FT_SLCuDan_Toa
SELECT FT_SLCuDan_Toa('TOA001');

-- 4.Tính tổng số lượng cư dân của chung cư.
DELIMITER //
CREATE FUNCTION FT_SLCuDan() 
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE SL INT;
    
    SELECT COUNT(MaCD) INTO SL
    FROM CuDan;
    
    RETURN SL;
END //
DELIMITER ;

-- Kiểm tra
SELECT FT_SLCuDan();

-- 5. Tính tổng chi phí trong 1 tháng của 1 căn hộ
DELIMITER //

CREATE FUNCTION FT_TongChiPhi_CanHo(p_MaCH CHAR(6), p_Thang INT, p_Nam INT)
RETURNS DECIMAL(12, 2)
DETERMINISTIC
BEGIN
    DECLARE CHIPHI DECIMAL(12, 2);
    
    SELECT COALESCE(SUM(TriGia), 0.00)
    INTO CHIPHI
    FROM HoaDon HD
    WHERE HD.MaCH = p_MaCH AND MONTH(HD.NgHD) = p_Thang AND YEAR(HD.NgHD) = p_Nam; 
    
    RETURN CHIPHI;
END //

DELIMITER ;

-- Kiểm tra
SELECT FT_TongChiPhi_CanHo('CH001', 4, 2024);

-- 6. Tính tổng trị giá hóa đơn với tình trạng chưa thanh toán của cư dân.
DELIMITER //
CREATE FUNCTION FT_TongHDChuaTT_CuDan(p_MaCD CHAR(6))
RETURNS DECIMAL(12, 2)
DETERMINISTIC
BEGIN
    DECLARE CHIPHI DECIMAL(12, 2);
    
    SELECT SUM(TriGia) INTO CHIPHI
    FROM HoaDon HD
    JOIN CuDan CD ON CD.MaCH = HD.MaCH
	WHERE CD.MaCD = p_MaCD 
		AND TinhTrang = 1;
    RETURN CHIPHI;
END //
DELIMITER ;

-- Kiểm tra
SELECT FT_TongHDChuaTT_CuDan('CD0001');

                                                              -- TẠO VIEW --
-- 1. Tổng số lượng căn hộ và số lượng căn hộ còn trống
CREATE VIEW View_SoLuongCanHo 
AS
	SELECT COUNT(*) AS TongCanHo, 
    SUM(TinhTrang = 1) AS CanHoTrong
	FROM CanHo;
    
-- Kiểm tra
SELECT * FROM View_SoLuongCanHo;

-- 2. Tổng số cư dân
CREATE VIEW View_SoLuongCuDan
AS
SELECT COUNT(*) AS TongCuDan,
       SUM(CASE WHEN MONTH(NgVaoO) 
       = MONTH(CURRENT_DATE()) AND YEAR(NgVaoO) 
       = YEAR(CURRENT_DATE()) THEN 1 ELSE 0 END) AS SoLuongCuDanMoiCuaThang
FROM CuDan;

-- Kiểm tra
SELECT * FROM View_SoLuongCuDan;

-- 3. Tổng số hóa đơn, Tổng chi phí hóa đơn, tổng hóa đơn đã thanh toán, tổng tiền đã thanh toán và dư nợ
CREATE VIEW View_TongChiPhiHoaDon 
AS
		SELECT 
			SUM(TriGia) AS TongChiPhiHoaDon,
			COUNT(*) AS TongHoaDon,
			SUM(TinhTrang = 2) AS HoaDonDaThanhToan,
			SUM(CASE WHEN TinhTrang = 2 THEN TriGia END) AS TongTienDaThanhToan,
			SUM(CASE WHEN TinhTrang = 1 THEN TriGia END) AS DuNo
		FROM HoaDon;

-- Kiểm tra
SELECT * FROM View_TongChiPhiHoaDon;

-- 4. Biểu đồ đường biểu diễn số lượng phản ánh của cư dân theo từng tháng
CREATE VIEW View_SoLuongPhanAnh
AS
		SELECT DATE_FORMAT(NgPA, '%m-%Y') AS Thang, COUNT(*) AS SoLuongPhanAnh
		FROM PhanAnh
		WHERE YEAR(NgPA) = YEAR(CURDATE())
		GROUP BY DATE_FORMAT(NgPA, '%m%Y')
		ORDER BY DATE_FORMAT(NgPA, '%m%Y');

-- Kiểm tra         
SELECT * FROM View_SoLuongPhanAnh;

-- 5. Biểu đồ tròn biểu diễn cơ cấu sử dụng từng loại dịch vụ
CREATE VIEW View_SoLuongDichVu
AS
	SELECT TenDV, COUNT(*) AS SoLuong
	FROM HoaDon
	JOIN DichVu ON HoaDon.MaDV = DichVu.MaDV
	GROUP BY DichVu.MaDV;

-- Kiểm tra 
SELECT * FROM View_SoLuongDichVu;

-- 6. Biểu đồ biểu diễn cơ cấu chi phí bỏ ra cho các dịch vụ
CREATE VIEW View_ChiPhiDichVu
AS
	SELECT DV.TenDV, SUM(HD.TriGia) AS TongChiPhi
	FROM HoaDon HD
	INNER JOIN DichVu DV ON HD.MaDV = DV.MaDV
	GROUP BY DV.MaDV, DV.TenDV;

-- Kiểm tra 
SELECT * FROM View_ChiPhiDichVu;

-- 7. Biểu đồ đường biểu diễn cư dân mới được thêm vào mỗi tháng trong 12 tháng đổ lại
CREATE VIEW View_CuDanMoiTheoThang
AS
	SELECT DATE_FORMAT(NgVaoO, '%m-%Y') AS Thang, COUNT(*) AS SoLuong
	FROM CuDan
	WHERE NgVaoO >= DATE_SUB(CURRENT_DATE(), INTERVAL 12 MONTH)
	GROUP BY YEAR(NgVaoO), MONTH(NgVaoO)
	ORDER BY DATE_FORMAT(NgVaoO, '%m-%Y');

-- Kiểm tra 
SELECT * FROM View_CuDanMoiTheoThang;

-- 8. Lập báo cáo hóa đơn (Mã hộ, tên chủ hộ, mã hóa đơn, trị giá, tình trạng)
CREATE VIEW View_BaoCaoHoaDon
AS
	SELECT CD.MaCH, CD.TenCD AS ChuHo, HD.TenHD, HD.TriGia, HD.NgHD,
		CASE 
			WHEN HD.TinhTrang = 1 THEN 'Chưa thanh toán'
			WHEN HD.TinhTrang = 2 THEN 'Đã thanh toán'
		END AS TinhTrang
	FROM CuDan CD
	INNER JOIN HoaDon HD ON CD.MaCH = HD.MaCH
    INNER JOIN CanHo CH ON CH.ChuHo = CD.MaCD;
    
-- Kiểm tra 
SELECT * FROM View_BaoCaoHoaDon;
 
-- 9. Lập báo cáo phụ trách dịch vụ hóa đơn (MaHD, MaNV, TenNV, TenDV)
CREATE VIEW View_BaoCaoPhuTrachDichVuHoaDon
AS
	SELECT HD.MaHD, NV.MaNV, NV.TenNV, DV.TenDV
	FROM NhanVien NV, HoaDon HD, DichVu DV, PhuTrach PT
	WHERE HD.MaHD = PT.MaHD AND HD.MaDV = DV.MaDV AND NV.MaNV = PT.MaNV;

-- Kiểm tra 
SELECT * FROM View_BaoCaoPhuTrachDichVuHoaDon;
 
-- 10. Biểu đồ thể hiện top 3 loại căn hộ được sử dụng nhiều nhất.
CREATE VIEW View_Top3CanHo
AS
	SELECT LoaiCH, COUNT(*) AS SoLuong
	FROM CanHo
	WHERE TinhTrang = 2
	GROUP BY LoaiCH
	ORDER BY SoLuong DESC
	LIMIT 3;

-- Kiểm tra 
SELECT * FROM View_Top3CanHo;

-- 11. Lập báo cáo các hộ cư dân quá hạn thanh toán hóa đơn (thời hạn thanh toán là 15 ngày kể từ khi có hóa đơn)
CREATE VIEW View_BaoCaoHoaDonQuaHan
AS
	SELECT CD.MaCH, CD.TenCD AS ChuHo, HD.MaHD, HD.TenHD, HD.TriGia,
    DATEDIFF(CURRENT_DATE(), HD.NgHD) AS SoNgayQuaHan
	FROM CuDan CD
	INNER JOIN HoaDon HD ON HD.MaCH = CD.MaCH
    INNER JOIN CanHo CH ON CH.ChuHo = CD.MaCD
	WHERE HD.TinhTrang = 1 AND DATEDIFF(CURRENT_DATE(), HD.NgHD) > 15;

-- Kiểm tra 
SELECT * FROM View_BaoCaoHoaDonQuaHan;


-- 12. Biểu đồ cột ghép tình trạng thanh toán hóa đơn của các tháng
CREATE VIEW View_TinhTrangThanhToan 
AS
    SELECT 
        DATE_FORMAT(HD.NgHD, '%m-%Y') AS Thang,
        SUM(TinhTrang = 1) AS 'Chưa thanh toán',
        SUM(TinhTrang = 2) AS 'Đã thanh toán'
    FROM HoaDon HD
    GROUP BY DATE_FORMAT(HD.NgHD, '%m-%Y');

-- Kiểm tra 
SELECT * FROM View_TinhTrangThanhToan;

-- 13. Số lượng cư dân theo giới tính
CREATE VIEW View_SoLuongGioiTinh
AS
	SELECT 
		SUM(GioiTinh = 'Nam') AS 'Nam',
        SUM(GioiTinh = 'Nữ') AS 'Nữ'
	FROM CuDan CD;

-- Kiểm tra 
SELECT * FROM View_SoLuongGioiTinh;

-- 14. View ẩn thông tin cho Nhân viên
CREATE VIEW  View_ThongTin_NhanVien AS
SELECT MaNV, TenNV, GioiTinh, SDT, DiaChi, NgVL, LoaiNV 
FROM NhanVien;

-- Vaitro QuanLy
REVOKE SELECT ON QLCHUNGCU.NhanVien FROM VaiTro_QuanLy;
GRANT SELECT ON QLCHUNGCU.View_ThongTin_NhanVien TO VaiTro_QuanLy;

-- Vaitro NhanVien
REVOKE SELECT ON QLCHUNGCU.NhanVien FROM VaiTro_NhanVien;
GRANT SELECT ON QLCHUNGCU.View_ThongTin_NhanVien TO VaiTro_NhanVien;

-- View ẩn thông tin cho Cư dân
CREATE VIEW  View_ThongTin_CuDan 
AS
	SELECT MaCD, TenCD, GioiTinh, SDT, NgSinh, QueQuan, MaCH, NgVaoO 
	FROM CuDan;

-- Vaitro Cư dân
REVOKE SELECT ON QLCHUNGCU.CuDan FROM VaiTro_CuDan;
GRANT SELECT ON QLCHUNGCU.View_ThongTin_CuDan TO VaiTro_CuDan;

-- 15. View xem danh sách chi tiết các căn hộ theo tầng và tòa.
CREATE VIEW View_DanhSach_CanHo_TheoTang_TheoToa 
AS
	SELECT toa.TenToa, tang.TenTang, ch.MaCH, ch.LoaiCH, ch.DienTich, ch.Gia
	FROM CanHo ch
	JOIN Tang tang ON ch.MaTang = tang.MaTang
	JOIN Toa toa ON tang.MaToa = toa.MaToa
	ORDER BY toa.TenToa, tang.TenTang, ch.MaCH;

-- Kiểm tra 
SELECT * FROM View_DanhSach_CanHo_TheoTang_TheoToa;

-- 16. View tính toán tổng số thiết bị được bố trí theo từng tòa
CREATE VIEW View_TongSoThietBi_TheoToa 
AS
    SELECT t.MaToa, SUM(bt.SL) AS TongSoThietBi
    FROM Toa t
    JOIN Tang tg ON t.MaToa = tg.MaToa 
    JOIN BoTri bt ON tg.MaTang = bt.MaTang
    GROUP BY t.MaToa;

-- Kiểm tra 
SELECT * FROM View_TongSoThietBi_TheoToa; 

                                                              -- PHÂN QUYỀN --
-- Tạo Role cho Quản Lý
CREATE ROLE 'VaiTro_QuanLy';

-- Tạo Role cho Nhân Viên
CREATE ROLE 'VaiTro_NhanVien';

-- Tạo Role cho Cư Dân 
CREATE ROLE 'VaiTro_CuDan';

-- Tạo Người dùng Quản lý và gán role
CREATE USER 'NguoiDung_QuanLy' @'localhost' IDENTIFIED BY 'QuanLy';
GRANT 'VaiTro_QuanLy' TO 'NguoiDung_QuanLy'@'localhost';
SET DEFAULT ROLE 'VaiTro_QuanLy' TO 'NguoiDung_QuanLy'@'localhost';

-- Tạo Người dùng Nhân viên và gán role
CREATE USER 'NguoiDung_NhanVien' @'localhost' IDENTIFIED BY 'NhanVien';
GRANT 'VaiTro_NhanVien' TO 'NguoiDung_NhanVien'@'localhost';
SET DEFAULT ROLE 'VaiTro_NhanVien' TO 'NguoiDung_NhanVien'@'localhost';

-- Tạo Người dùng Cư dân và gán Role
CREATE USER 'NguoiDung_CuDan' @'localhost' IDENTIFIED BY 'CuDan';
GRANT 'VaiTro_CuDan' TO 'NguoiDung_CuDan'@'localhost';
SET DEFAULT ROLE 'VaiTro_CuDan' TO 'NguoiDung_CuDan'@'localhost';

-- Gán bảng cho Quản lý
GRANT SELECT(MaNV, TenNV, GioiTinh, SDT, DiaChi, NgSinh, NgVL, LoaiNV), INSERT, UPDATE(MaNV, TenNV, GioiTinh, SDT, DiaChi, NgSinh, NgVL, LoaiNV) ON QLCHUNGCU.NhanVien TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE, DELETE ON QLCHUNGCU.DichVu TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE ON QLCHUNGCU.HoaDon TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT SELECT(MaCD, TenCD, GioiTinh, SDT, NgSinh, QueQuan, MaCH, NgVaoO) ON QLCHUNGCU.CuDan TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE, DELETE ON QLCHUNGCU.ThongBao TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE ON QLCHUNGCU.CanHo TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE, DELETE ON QLCHUNGCU.ThietBi TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE ON QLCHUNGCU.Tang TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE ON QLCHUNGCU.Toa TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE ON QLCHUNGCU.PhanAnh TO VaiTro_QuanLy WITH GRANT OPTION;

-- Gán Stored procedures cho Quản lý
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_In_DS_Cudan TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_In_DSHoadon_CanHo TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_In_DSCuDan_CanHo TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_In_DSNV_LoaiNV TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_In_DSCanHo_ChuaThanhToanHD TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_CapNhatTT_CanHo TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_TimThongBao_Ngay TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_In_TTCuDan_MaCD TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_GuiThongBaoChoCanHo TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_GuiThongBaoChoTatCaCanHo TO VaiTro_QuanLy WITH GRANT OPTION;

-- Gán Functions cho Quản lý
GRANT EXECUTE ON FUNCTION QLCHUNGCU.FT_SoCanHo TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT EXECUTE ON FUNCTION QLCHUNGCU.FT_SoPhongTrong TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT EXECUTE ON FUNCTION QLCHUNGCU.FT_SLCuDan_Toa TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT EXECUTE ON FUNCTION QLCHUNGCU.FT_SLCuDan TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT EXECUTE ON FUNCTION QLCHUNGCU.FT_TongChiPhi_CanHo TO VaiTro_QuanLy WITH GRANT OPTION;
GRANT EXECUTE ON FUNCTION QLCHUNGCU.FT_TongHDChuaTT_CuDan TO VaiTro_QuanLy WITH GRANT OPTION;

-- Gán bảng cho Nhân Viên
GRANT SELECT(MaNV, TenNV, GioiTinh, SDT, DiaChi, NgSinh, NgVL, LoaiNV), UPDATE(MaNV, TenNV, GioiTinh, SDT, DiaChi, NgSinh, NgVL, LoaiNV) ON QLCHUNGCU.NhanVien TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE, DELETE ON QLCHUNGCU.DichVu TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE ON QLCHUNGCU.HoaDon TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT SELECT(MaCD, TenCD, GioiTinh, SDT, NgSinh, QueQuan, MaCH, NgVaoO) ON QLCHUNGCU.CuDan TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE, DELETE ON QLCHUNGCU.ThongBao TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE ON QLCHUNGCU.CanHo TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE, DELETE ON QLCHUNGCU.ThietBi TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE ON QLCHUNGCU.Tang TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE ON QLCHUNGCU.Toa TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE ON QLCHUNGCU.PhanAnh TO VaiTro_NhanVien WITH GRANT OPTION;

-- Gán Stored procedures cho Nhân Viên
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_In_DS_Cudan TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_In_DSHoadon_CanHo TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_In_DSCuDan_CanHo TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_In_DSNV_LoaiNV TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_In_DSCanHo_ChuaThanhToanHD TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_CapNhatTT_CanHo TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_TimThongBao_Ngay TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_In_TTCuDan_MaCD TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_GuiThongBaoChoCanHo TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_GuiThongBaoChoTatCaCanHo TO VaiTro_NhanVien WITH GRANT OPTION;

-- Gán Functions cho Nhân Viên
GRANT EXECUTE ON FUNCTION QLCHUNGCU.FT_SoCanHo TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT EXECUTE ON FUNCTION QLCHUNGCU.FT_SoPhongTrong TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT EXECUTE ON FUNCTION QLCHUNGCU.FT_SLCuDan_Toa TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT EXECUTE ON FUNCTION QLCHUNGCU.FT_SLCuDan TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT EXECUTE ON FUNCTION QLCHUNGCU.FT_TongChiPhi_CanHo TO VaiTro_NhanVien WITH GRANT OPTION;
GRANT EXECUTE ON FUNCTION QLCHUNGCU.FT_TongHDChuaTT_CuDan TO VaiTro_NhanVien WITH GRANT OPTION;

-- Gán bảng cho Cư Dân
GRANT SELECT ON QLCHUNGCU.DichVu TO VaiTro_CuDan WITH GRANT OPTION;
GRANT SELECT ON QLCHUNGCU.HoaDon TO VaiTro_CuDan WITH GRANT OPTION;
GRANT SELECT, UPDATE ON QLCHUNGCU.CuDan TO VaiTro_CuDan WITH GRANT OPTION;
GRANT SELECT ON QLCHUNGCU.ThongBao TO VaiTro_CuDan WITH GRANT OPTION;
GRANT SELECT ON QLCHUNGCU.CanHo TO VaiTro_CuDan WITH GRANT OPTION;
GRANT SELECT ON QLCHUNGCU.ThietBi TO VaiTro_CuDan WITH GRANT OPTION;
GRANT SELECT ON QLCHUNGCU.Tang TO VaiTro_CuDan WITH GRANT OPTION;
GRANT SELECT ON QLCHUNGCU.Toa TO VaiTro_CuDan WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE, DELETE ON QLCHUNGCU.PhanAnh TO VaiTro_CuDan WITH GRANT OPTION;

-- Gán Stored Procedures cho Cư Dân
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_TimThongBao_Ngay TO VaiTro_CuDan WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_In_TTCuDan_MaCD TO VaiTro_CuDan WITH GRANT OPTION;
GRANT EXECUTE ON PROCEDURE QLCHUNGCU.SP_CapNhatTT_CanHo TO VaiTro_CuDan WITH GRANT OPTION;

                                                              -- MÃ HÓA --

ALTER TABLE CuDan ADD salt CHAR(36);
ALTER TABLE NhanVien ADD salt CHAR(36);
-- 1. Trigger mã hóa mật khẩu cư dân
-- Khi insert
DELIMITER //
CREATE TRIGGER I_CD_MaHoa
BEFORE INSERT ON CuDan
FOR EACH ROW
BEGIN
    -- Tạo giá trị ngẫu nhiên của salt
    DECLARE p_salt CHAR(36);
    DECLARE p_MatKhau BLOB;
    
    SET p_MatKhau = CONCAT(LPAD(DAY(NEW.NgSinh), 2, 0), LPAD(MONTH(NEW.NgSinh), 2, 0), YEAR(NEW.NgSinh));
    SET p_salt = UUID();  -- Tạo giá trị salt ngẫu nhiên
    
    -- Gán giá trị salt mới tạo cho trường salt của hàng mới
    SET NEW.salt = p_salt;
    
    -- Mã hóa mật khẩu với AES_ENCRYPT với key là MaCD
    SET p_MatKhau = AES_ENCRYPT(CONCAT(p_MatKhau, p_salt), NEW.MaCD);
    
    -- Mã hóa mật khẩu đã mã hóa bằng SHA2
    SET NEW.MatKhau = SHA2(p_MatKhau, 256);
END //
DELIMITER ;

-- Khi update
DELIMITER //
CREATE TRIGGER U_CD_MaHoa
BEFORE UPDATE ON CuDan
FOR EACH ROW
BEGIN
    -- Tạo giá trị ngẫu nhiên của salt
    DECLARE p_salt CHAR(36);
    DECLARE p_MatKhau BLOB;

IF OLD.MatKhau <> NEW.MatKhau THEN
    SET p_salt = UUID();  -- Tạo giá trị salt ngẫu nhiên
    
    -- Gán giá trị salt mới tạo cho trường salt của hàng mới
    SET NEW.salt = p_salt;
    
    -- Mã hóa mật khẩu với AES_ENCRYPT với key là MaCD
    SET p_MatKhau = AES_ENCRYPT(CONCAT(NEW.MatKhau, p_salt), NEW.MaCD);
    
    -- Mã hóa mật khẩu đã mã hóa bằng SHA2
    SET NEW.MatKhau = SHA2(p_MatKhau, 256);
END IF;
END //
DELIMITER ;

-- 2. Trigger mã hóa mật khẩu nhân viên
-- Khi insert
DELIMITER //
CREATE TRIGGER I_NV_MaHoa
BEFORE INSERT ON NhanVien
FOR EACH ROW
BEGIN
    -- Tạo giá trị ngẫu nhiên của salt
    DECLARE p_salt CHAR(36);
    DECLARE p_MatKhau BLOB;
    
	SET p_MatKhau = CONCAT(LPAD(DAY(NEW.NgSinh), 2, 0), LPAD(MONTH(NEW.NgSinh), 2, 0), YEAR(NEW.NgSinh));
    SET p_salt = UUID(); 
    
    -- Gán giá trị salt
    SET NEW.salt = p_salt;
    
    -- Mã hóa mật khẩu với AES_ENCRYPT với key là MaNV
    SET p_MatKhau = AES_ENCRYPT(CONCAT(p_MatKhau, p_salt), NEW.MaNV);
    
    -- Mã hóa mật khẩu đã mã hóa bằng SHA2
    SET NEW.MatKhau = SHA2(p_MatKhau, 256);
END //
DELIMITER ;

-- Khi update
DELIMITER //
CREATE TRIGGER U_NV_MaHoa
BEFORE UPDATE ON NhanVien
FOR EACH ROW
BEGIN
    -- Tạo giá trị ngẫu nhiên của salt
    DECLARE p_salt CHAR(36);
    DECLARE p_MatKhau BLOB;
    
IF OLD.MatKhau <> NEW.MatKhau THEN

	-- Tạo giá trị salt ngẫu nhiên
    SET p_salt = UUID(); 
    
    -- Gán giá trị salt
    SET NEW.salt = p_salt;
    
    -- Mã hóa mật khẩu với AES_ENCRYPT với key là MaCD
    SET p_MatKhau = AES_ENCRYPT(CONCAT(NEW.MatKhau, p_salt), NEW.MaNV);
    
    -- Mã hóa mật khẩu đã mã hóa bằng SHA2
    SET NEW.MatKhau = SHA2(p_MatKhau, 256);
END IF;
END //
DELIMITER ;

-- Hàm xác thực mật khẩu
DELIMITER //
CREATE FUNCTION XacThuc_MK_CD (p_MaCD CHAR(6), p_MatKhau CHAR(255))
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
	DECLARE p_MaHoa CHAR(255);
    DECLARE p_salt CHAR(255);
    DECLARE p_MK CHAR(255);
    
    SELECT salt, MatKhau INTO p_salt, p_MK
    FROM CuDan
    WHERE MaCD = p_MaCD;
    SET p_MaHoa = SHA2(AES_ENCRYPT(CONCAT(p_MatKhau, p_salt), p_MaCD), 256);
    IF (p_MaHoa = p_MK) THEN
		RETURN TRUE;
	ELSE
		RETURN FALSE;
	END IF;
END //
DELIMITER ;

-- Hàm xác thực mật khẩu cho nhân viên
DELIMITER //
CREATE FUNCTION XacThuc_MK_NV (p_MaNV CHAR(6), p_MatKhau CHAR(255))
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
	DECLARE p_MaHoa CHAR(255);
    DECLARE p_salt CHAR(255);
    DECLARE p_MK CHAR(255);
    
    SELECT salt, MatKhau INTO p_salt, p_MK
    FROM NhanVien
    WHERE MaNV = p_MaNV;
    SET p_MaHoa = SHA2(AES_ENCRYPT(CONCAT(p_MatKhau, p_salt), p_MaNV), 256);
    IF (p_MaHoa = p_MK) THEN
		RETURN TRUE;
	ELSE
		RETURN FALSE;
	END IF;
END //
DELIMITER ;

                                                              -- THÊM DỮ LIỆU --

-- Dữ liệu cho bảng NhanVien
    INSERT INTO NhanVien (MaNV, TenNV, GioiTinh, SDT, DiaChi, NgSinh, NgVL, LoaiNV) VALUES
    ('NV0001', 'Nguyễn Anh Dương', 'Nam', '0987654321', '123 Nguyễn Huệ, Quận 1, TP.HCM', '1987-05-15', '2012-05-15', 'Bảo vệ'),
    ('NV0002', 'Trần Minh Thanh', 'Nữ', '0123456789', '456 Hai Bà Trưng, Quận 2, TP.HCM', '1990-10-20', '2015-10-20', 'Lao công'),
    ('NV0003', 'Lê Thị Linh', 'Nam', '0398765432', '789 Lý Tự Trọng, Quận 3, TP.HCM', '1993-12-03', '2018-12-03', 'Bảo trì'),
    ('NV0004', 'Phạm Văn Minh', 'Nữ', '0567891234', '321 Lê Duẩn, Quận 4, TP.HCM', '1985-08-28', '2011-08-28', 'Quản lý'),
    ('NV0005', 'Hoàng Duy Khánh', 'Nam', '0123654789', '567 Hùng Vương, Quận 5, TP.HCM', '1990-03-10', '2016-03-10', 'Bảo vệ'),
    ('NV0006', 'Nguyễn Thị Hồng', 'Nữ', '0967854321', '890 Nguyễn Trãi, Quận 6, TP.HCM', '1989-07-25', '2014-07-25', 'Quản lý'),
    ('NV0007', 'Trần Ngọc Anh', 'Nam', '0396548732', '234 Nguyễn Thị Minh Khai, Quận 7, TP.HCM', '1995-11-18', '2019-11-18', 'Bảo trì'),
    ('NV0008', 'Đỗ Thị Lan', 'Nữ', '0765432198', '135 Bạch Đằng, Quận 1, TP.HCM', '1998-04-01', '2020-04-01', 'Lao công'),
    ('NV0009', 'Phan Thị Mai', 'Nữ', '0678912345', '246 Lê Lợi, Quận 2, TP.HCM', '1997-05-12', '2021-05-12', 'Lao công'),
    ('NV0010', 'Nguyễn Thị Tuyết', 'Nữ', '0581234679', '357 Trần Hưng Đạo, Quận 3, TP.HCM', '2000-06-23', '2023-06-23', 'Lao công'),
    ('NV0011', 'Trịnh Minh Tinh', 'Nữ', '0878909404', '517 Thích Quảng Đức, Phú Nhuận, Tp.HCM', '1989-05-19', '2023-05-19', 'Quản lý'),
    ('NV0012', 'Nguyễn Quang Trung', 'Nam', '0864509905', '2 Phan Huy Ích, Gò Vấp, TP.HCM', '1993-07-24', '2023-07-24', 'Bảo vệ'),
    ('NV0013', 'Nguyễn Diệp Anh', 'Nữ', '0924608193', '123 Nguyễn Cơ Thạch, Cầu Giấy, Hà Nội', '1999-06-10', '2023-07-24', 'Kế toán'),
    ('NV0014', 'Trần Nam Anh', 'Nam', '0962342550', '123 Nguyễn Thị Minh Khai, Quận 1, TP.HCM', '1989-09-11', '2010-07-05', 'BQT'),
    ('NV0015', 'Hoàng Ngọc Bách', 'Nam', '0834082001', '456 Lê Lai, Quận 10, TP.HCM', '1995-08-12', '2019-12-20', 'Lao công'),
    ('NV0016', 'Nguyễn Thị Kim Dung', 'Nữ', '0163533789', '789 Nguyễn Trãi, Hà Đông, Hà Nội', '1996-06-14', '2018-06-02', 'Bảo vệ'),
    ('NV0017', 'Phạm Hồng Đăng', 'Nam', '0984476509', '321 Láng Hạ, Đống Đa, Hà Nội', '1990-05-13', '2017-09-10', 'Kế toán'),
    ('NV0018', 'Vũ Việt Hà', 'Nữ', '0973266558', '567 Võ Văn Tần, Quận 3, TP.HCM', '1980-02-16', '2015-04-18', 'Quản lý'),
    ('NV0019', 'Trần Ngọc Hà', 'Nữ', '0924655434', '890 Lê Lợi, Quận 1, TP.HCM', '1990-04-16', '2014-11-30', 'Tư vấn'),
    ('NV0020', 'Đào Minh Hạnh', 'Nữ', '0941688538', '234 Hoàng Văn Thụ, Quận Tân Bình, TP.HCM', '1997-11-15', '2016-08-25', 'Bảo trì'),
    ('NV0021', 'Đỗ Quốc Hưng', 'Nam', '0162765429', '135 Huỳnh Thúc Kháng, Đống Đa, Hà Nội', '1995-06-17', '2018-03-12', 'Kế toán'),
    ('NV0022', 'Lê Phương Liên', 'Nữ', '0924655435', '246 Nguyễn Thị Minh Khai, Quận 3, TP.HCM', '2000-07-11', '2019-10-08', 'Bảo vệ'),
    ('NV0023', 'Nguyễn Anh Mai', 'Nữ', '0924655437', '357 Lê Hồng Phong, Quận 10, TP.HCM', '1988-08-04', '2020-05-15', 'Quản lý'),
    ('NV0024', 'Nguyễn Hoàng Nam', 'Nam', '0924655441', '517 Bà Triệu, Hai Bà Trưng, Hà Nội', '1992-07-06', '2020-02-28', 'Kế toán'),
    ('NV0025', 'Trần Lê Nguyên', 'Nam', '0924655440', '2 Lê Duẩn, Quận 1, TP.HCM', '1988-08-26', '2014-09-03', 'Tư vấn'),
    ('NV0026', 'Trịnh Hà Phương', 'Nữ', '0924655436', '890 Nguyễn Chí Thanh, Đống Đa, Hà Nội', '1988-08-22', '2017-11-20', 'Quản lý'),
    ('NV0027', 'Lê Minh Tâm', 'Nam', '0924655443', '234 Nam Kỳ Khởi Nghĩa, Quận 3, TP.HCM', '1989-12-08', '2019-02-14', 'Quản lý'),
    ('NV0028', 'Trần Diệu Thúy', 'Nữ', '0924681193', '135 Cầu Giấy, Cầu Giấy, Hà Nội', '1996-03-18', '2020-07-30', 'Bảo trì'),
    ('NV0029', 'Trịnh Minh Thư', 'Nữ', '0924655438', '246 Thái Hà, Đống Đa, Hà Nội', '1989-08-24', '2016-04-05', 'Lao công'),
    ('NV0030', 'Lê Minh Trí', 'Nam', '0924655433', '357 Nguyễn Thị Minh Khai, Quận 3, TP.HCM', '1978-08-19', '2018-10-19', 'Kế toán'),
    ('NV0031', 'Đinh Quốc Trung', 'Nam', '0924655439', '2 Nguyễn Văn Cừ, Long Biên, Hà Nội', '1993-06-29', '2019-08-07', 'Tư vấn'),
    ('NV0032', 'Vũ Quang Vinh', 'Nam', '0924655442', '517 Lê Duẩn, Quận 1, TP.HCM', '1988-08-28', '2015-12-10', 'Bảo vệ');

-- Thêm dữ liệu vào bảng Toa
INSERT INTO Toa (MaToa, TenToa, SoTang, MoTa) VALUES
    ('TOA001', 'Tòa A', 15, 'Tòa chung cư cao cấp với đầy đủ tiện nghi'),
    ('TOA002', 'Tòa B', 15, 'Tòa chung cư cao cấp với view đẹp'),
    ('TOA003', 'Tòa C', 15, 'Tòa chung cư cao cấp với khu vui chơi và phòng gym');
    
-- Dữ liệu cho bảng Tang
INSERT INTO Tang (MaTang, TenTang, SoCH, MaToa) VALUES
    ('A01', 'Tầng A01', 10, 'TOA001'),
    ('A02', 'Tầng A02', 10, 'TOA001'),
    ('A03', 'Tầng A03', 10, 'TOA001'),
    ('A04', 'Tầng A04', 10, 'TOA001'),
    ('A05', 'Tầng A05', 10, 'TOA001'),
    ('A06', 'Tầng A06', 10, 'TOA001'),
    ('B01', 'Tầng B01', 12, 'TOA002'),
    ('B02', 'Tầng B02', 12, 'TOA002'),
    ('B03', 'Tầng B03', 12, 'TOA002'),
    ('B04', 'Tầng B04', 12, 'TOA002'),
    ('B05', 'Tầng B05', 12, 'TOA002'),
    ('B06', 'Tầng B06', 12, 'TOA002'),
    ('C01', 'Tầng C01', 15, 'TOA003'),
    ('C02', 'Tầng C02', 15, 'TOA003'),
    ('C03', 'Tầng C03', 15, 'TOA003'),
    ('C04', 'Tầng C04', 15, 'TOA003'),
    ('C05', 'Tầng C05', 15, 'TOA003'),
    ('C06', 'Tầng C06', 15, 'TOA003');

-- Dữ liệu cho bảng CanHo
-- Dữ liệu cho bảng CanHo
INSERT INTO CanHo (MaCH, LoaiCH, MoTa, DienTich, Gia, MaTang, TinhTrang) VALUES
    ('CH001', 'Basic 4', 'Căn hộ thông thường 4 phòng ngủ, có ban công hướng Nam', 120.5, 5000000000, 'A01', 2),
    ('CH002', 'Basic 3', 'Căn hộ thông thường 3 phòng ngủ, có ban công hướng Tây Nam', 90.2, 3500000000, 'A01', 2),
    ('CH003', 'Basic 3', 'Căn hộ thông thường 3 phòng ngủ, có ban công hướng Bắc', 95.0, 4000000000, 'A02', 2),
    ('CH004', 'Basic 4', 'Căn hộ thông thường 4 phòng ngủ, có ban công hướng Đông', 150.0, 6000000000, 'B02', 2),
    ('CH005', 'Basic 3', 'Căn hộ thông thường 3 phòng ngủ, có ban công hướng Nam', 110.0, 4800000000, 'B03', 2),
    ('CH006', 'Basic 2', 'Căn hộ thông thường 2 phòng ngủ, có ban công hướng Bắc', 85.5, 3000000000, 'B03', 2),
    ('CH007', 'Basic 2', 'Căn hộ thông thường 2 phòng ngủ, có ban công hướng Tây', 92.0, 3550000000, 'B04', 2),
    ('CH008', 'Basic 1', 'Căn hộ thông thường 1 phòng ngủ, có ban công hướng Đông Nam', 75.0, 2800000000, 'C04', 2),
    ('CH009', 'Studio', 'Căn hộ studio, thiết kế mở với không gian sống và phòng ngủ kết hợp', 60.0, 1200000000, 'C05', 2),
    ('CH010', 'Shophouse', 'Căn hộ thương mại, có thể sử dụng để kinh doanh hoặc cho thuê', 200.0, 10000000000, 'A01', 2),
    ('CH011', 'Officetel', 'Căn hộ văn phòng, thích hợp để làm văn phòng và nơi ở kết hợp', 50.0, 1000000000, 'B02', 1),
    ('CH012', 'Penthouse', 'Căn hộ penthouse, có thiết kế thông thường với không gian rộng rãi', 150.0, 12000000000, 'C06', 1),
    ('CH013', 'Penthouse', 'Căn hộ penthouse thông tầng, thiết kế cao cấp với không gian sang trọng', 200.0, 20000000000, 'C05', 1),
    ('CH014', 'Sky Villa', 'Căn hộ cao cấp nằm ở tầng cao nhất của tòa nhà, không gian rộng rãi và sang trọng như một biệt thự', 200.0, 100000000000, 'C06', 1),
    ('CH015', 'Basic 1', 'Căn hộ thông thường 1 phòng ngủ, có ban công hướng Đông', 75.0, 1000000000, 'B05', 1);

-- Dữ liệu cho bảng DichVu
INSERT INTO DichVu (MaDV, TenDV, PhiDV) VALUES
    ('DV01', 'Dọn dẹp, thu gom rác', 100000),
    ('DV02', 'Bảo dưỡng nội thất', 200000),
    ('DV03', 'Sửa chữa hệ thống điện nước', 300000),
    ('DV04', 'Gửi xe', 200000),
    ('DV05', 'An ninh', 100000),
    ('DV06', 'Dịch vụ khác', 0),
    ('DV07', 'Quản lý', 600000);

-- Dữ liệu cho bảng CuDan
INSERT INTO CuDan (MaCD, TenCD, GioiTinh, SDT, NgSinh, QueQuan, MaCH, NgVaoO) VALUES
    ('CD0001', 'Nguyễn Thị Lan', 'Nữ', '0336278378', '1975-05-15', 'Hà Nội', 'CH001', '2023-01-20'),
    ('CD0002', 'Trần Văn Nam', 'Nam', '0122367899', '1972-07-20', 'Hồ Chí Minh', 'CH001', '2023-01-20'),
    ('CD0003', 'Trần Thị Thảo', 'Nữ', '0988888821', '1992-11-03', 'Hồ Chí Minh', 'CH001', '2023-01-20'),
    ('CD0004', 'Trần Văn Hùng', 'Nam', NULL, '2010-08-28', 'Hồ Chí Minh', 'CH001', '2023-01-20'),
    ('CD0005', 'Hoàng Thị Ngọc', 'Nữ', '0231980676', '1985-03-10', 'Huế', 'CH002', '2023-02-21'),
    ('CD0006', 'Nguyễn Văn Đức', 'Nam', '0123786599', '1985-07-25', 'Quảng Ninh', 'CH002', '2024-02-21'),
    ('CD0007', 'Nguyễn Thị Thanh', 'Nữ', NULL, '2015-11-18', 'Quảng Ninh', 'CH002', '2024-02-21'),
    ('CD0008', 'Đỗ Văn Tâm', 'Nam', '0365432198', '1999-04-01', 'Nghệ An', 'CH003', '2023-12-22'),
    ('CD0009', 'Phan Mạnh Hùng', 'Nam', '0367812345', '1999-05-12', 'Hà Tĩnh', 'CH003', '2023-12-22'),
    ('CD0010', 'Nguyễn Văn Thắng', 'Nam', '0987678987', '1999-06-23', 'Thanh Hóa', 'CH003', '2023-12-22'),
    ('CD0011', 'Trần Thị Thu', 'Nữ', '0256723437', '2002-09-15', 'Ninh Bình', 'CH004', '2024-03-23'),
    ('CD0012', 'Lê Yến Nhi', 'Nữ', '0456789123', '2002-07-25', 'Hà Nam', 'CH004', '2024-03-23'),
    ('CD0013', 'Phạm Thị Mai', 'Nữ', '0982345900', '2002-12-03', 'Nam Định', 'CH004', '2024-03-23'),
    ('CD0014', 'Hoàng Xuân Mai', 'Nữ', '0398765432', '2004-10-28', 'Thái Bình', 'CH004', '2024-03-23'),
    ('CD0015', 'Nguyễn Thị Thúy', 'Nữ', NULL, '2001-05-05', 'Hưng Yên', 'CH004', '2024-03-23'),
    ('CD0016', 'Trần Văn Tú', 'Nam', '0345654111', '1973-09-20', 'Hà Nam', 'CH005', '2024-01-24'),
    ('CD0017', 'Đỗ Thị Tuyết', 'Nữ', '0868807090', '1984-03-01', 'Ninh Bình', 'CH005', '2024-01-24'),
    ('CD0018', 'Trần Văn Đại', 'Nam', '0678912345', '2004-02-12',  'Hồ Chí Minh', 'CH005', '2024-01-24'),
    ('CD0019', 'Trần Thị Hà', 'Nữ', '0581234679', '2005-10-17',  'Hồ Chí Minh', 'CH005', '2024-01-24'),
    ('CD0020', 'Nguyễn Văn Tú', 'Nam', NULL, '2017-07-07', 'Hà Nội', 'CH006', '2024-01-25'),
    ('CD0021', 'Trần Thị Thanh', 'Nữ', NULL, '2015-04-05',  'Hà Nội', 'CH006', '2024-01-25'),
    ('CD0022', 'Lê Tâm Vy', 'Nữ', '0987678678', '1990-08-23',  'Hà Nội', 'CH006', '2024-01-25'),
    ('CD0023', 'Phạm Thị An', 'Nữ', '0987765431', '1986-11-30', 'Hải Phòng', 'CH007', '2024-01-26'),
    ('CD0024', 'Hoàng Văn Tâm', 'Nam', '0567891234', '1983-06-25', 'Huế', 'CH007', '2024-01-26'),
    ('CD0025', 'Nguyễn Thị Lan', 'Nữ', 'NULL', '2018-05-10', 'Huế', 'CH007', '2024-01-26'),
    ('CD0026', 'Trần Văn Anh', 'Nam', '0321456789', '1992-10-20', 'Vĩnh Phúc', 'CH008', '2023-12-27'),
    ('CD0027', 'Đỗ Văn Hà', 'Nam', NULL, '1995-12-03', 'Nghệ An', 'CH008', '2023-01-27'),
    ('CD0028', 'Phan Văn Đức', 'Nam', '0765432198', '1999-06-15', 'Hà Tĩnh', 'CH009', '2023-12-28'),
    ('CD0029', 'Lê Thị Mai', 'Nữ', '0678812345', '1997-07-23', 'Thanh Hóa', 'CH009', '2023-12-28'),
    ('CD0030', 'Nguyễn Văn Tú', 'Nam', '0854678987', '1994-08-30', 'Nam Định', 'CH010', '2023-11-29'),
	('CD0031', 'Trịnh Tú Nhi', 'Nữ', '0271458888', '1999-08-10', 'Long An', 'CH010', '2024-05-02'),
	('CD0032', 'Trần Ánh My', 'Nữ', '0936278378', '1999-05-12', 'Hà Nội', 'CH001', '2024-05-10');    
 
 -- Cập nhật chủ hộ
UPDATE CanHo
SET ChuHo = 'CD0001'
WHERE MaCH = 'CH001';

UPDATE CanHo
SET ChuHo = 'CD0005'
WHERE MaCH = 'CH002';

UPDATE CanHo
SET ChuHo = 'CD0008'
WHERE MaCH = 'CH003';

UPDATE CanHo
SET ChuHo = 'CD0011'
WHERE MaCH = 'CH004';

UPDATE CanHo
SET ChuHo = 'CD0016'
WHERE MaCH = 'CH005';

UPDATE CanHo
SET ChuHo = 'CD0022'
WHERE MaCH = 'CH006';

UPDATE CanHo
SET ChuHo = 'CD0023'
WHERE MaCH = 'CH007';

UPDATE CanHo
SET ChuHo = 'CD0026'
WHERE MaCH = 'CH008';

UPDATE CanHo
SET ChuHo = 'CD0028'
WHERE MaCH = 'CH009';

UPDATE CanHo
SET ChuHo = 'CD0030'
WHERE MaCH = 'CH010';
 
-- Dữ liệu cho bảng HoaDon
INSERT INTO HoaDon (MaHD, TenHD, NgHD, PhiPS, TinhTrang, GhiChu, MaDV, MaCH) VALUES
    ('HD001', 'Hóa đơn điện nước', '2024-04-01 00:00:00', 600000, 1, NULL, 'DV06', 'CH001'),
    ('HD002', 'Hóa đơn dịch vụ vệ sinh', '2024-02-15 00:00:00', 0, 2, NULL, 'DV01', 'CH002'),
    ('HD003', 'Hóa đơn bảo dưỡng', '2024-03-20 00:00:00', 100000, 2, 'Thay 2 bóng đèn', 'DV03', 'CH003'),
    ('HD004', 'Hóa đơn gửi xe', '2024-03-26 00:00:00', 50000, 1, '2 xe máy' , 'DV04', 'CH004'),
    ('HD005', 'Hóa đơn an ninh', '2024-03-29 00:00:00', 0, 2, NULL,'DV05', 'CH005'),
    ('HD006', 'Hóa đơn dịch vụ Internet', '2024-02-28 00:00:00', 50000, 2, NULL, 'DV06', 'CH006'),
    ('HD007', 'Hóa đơn điện nước', '2024-04-01 00:00:00', 650000, 1, NULL, 'DV01', 'CH007'),
    ('HD008', 'Hóa đơn dịch vụ vệ sinh', '2024-01-21 00:00:00', 0, 2, NULL, 'DV01', 'CH008'),
    ('HD009', 'Hóa đơn bảo dưỡng', '2024-03-13 00:00:00', 0, 1, NULL, 'DV02', 'CH009'),
    ('HD010', 'Hóa đơn gửi xe', '2024-01-30 00:00:00', 100000, 2, '1 xe máy, 1 ô tô', 'DV04', 'CH010'),
    ('HD011', 'Hóa đơn vệ sinh', '2024-02-15 00:00:00', 0, 2, NULL, 'DV01', 'CH005'),
    ('HD012', 'Hóa đơn dịch vụ điện nước', '2024-04-01 00:00:00', 240000, 1, NULL, 'DV06', 'CH002'),
    ('HD013', 'Hóa đơn bảo dưỡng', '2024-02-20 00:00:00',  150000, 2, 'Sửa máy lạnh', 'DV03', 'CH010'),
    ('HD014', 'Hóa đơn an ninh', '2024-03-30 00:00:00', 0, 1, NULL, 'DV05', 'CH004'),
    ('HD015', 'Hóa đơn điện nước', '2024-04-30 00:00:00', 1350000, 1, NULL, 'DV06', 'CH008'),
    ('HD016', 'Phí quản lý', '2023-12-25 00:00:00', 0, 2, NULL, 'DV07', 'CH001'),
    ('HD017', 'Hóa đơn bảo dưỡng', '2024-01-10 00:00:00', 150000, 1,'Thay dây điện', 'DV03', 'CH002'),
    ('HD018', 'Hóa đơn gửi xe', '2024-02-05 00:00:00', 100000, 2, '1 ô tô', 'DV04', 'CH003'),
    ('HD019', 'Hóa đơn an ninh', '2024-03-15 00:00:00', 0, 1, NULL, 'DV05', 'CH004'),
    ('HD020', 'Hóa đơn dịch vụ Internet', '2024-04-20 00:00:00', 50000, 1, NULL, 'DV06', 'CH005'),
    ('HD021', 'Phí quản lý', '2024-04-25 00:00:00', 0, 2, NULL, 'DV07', 'CH006'),
    ('HD022', 'Hóa đơn bảo dưỡng', '2024-03-10 00:00:00', 200000, 1, 'Thay ổ cắm', 'DV03', 'CH007'),
    ('HD023', 'Hóa đơn gửi xe', '2024-05-05 00:00:00', 150000, 2, '2 xe máy', 'DV04', 'CH008'),
    ('HD024', 'Hóa đơn an ninh', '2024-05-15 00:00:00', 0, 1, NULL, 'DV05', 'CH009'),
    ('HD025', 'Hóa đơn điện nước', '2024-03-20 00:00:00', 1200000, 1, NULL, 'DV06', 'CH010'),
    ('HD026', 'Hóa đơn dịch vụ vệ sinh', '2024-04-25 00:00:00', 800000, 2, NULL, 'DV01', 'CH003'),
    ('HD027', 'Hóa đơn bảo dưỡng', '2024-03-10 00:00:00', 250000, 1, 'Thay bóng đèn', 'DV03', 'CH010'),
    ('HD028', 'Hóa đơn gửi xe', '2024-01-05 00:00:00', 200000, 2, '3 xe máy', 'DV04', 'CH005'),
    ('HD029', 'Hóa đơn an ninh', '2024-01-15 00:00:00', 0, 1, NULL, 'DV05', 'CH001'),
    ('HD030', 'Hóa đơn điện nước', '2024-02-20 00:00:00', 900000, 1, NULL, 'DV06', 'CH002'),
    ('HD031', 'Phí quản lý', '2024-03-25 00:00:00', 0, 2, NULL, 'DV07', 'CH010'),
    ('HD032', 'Hóa đơn bảo dưỡng', '2024-04-10 00:00:00', 300000, 1, 'Sửa ổ cắm', 'DV03', 'CH008'),
    ('HD033', 'Hóa đơn gửi xe', '2024-05-05 00:00:00', 250000, 2, '4 xe máy', 'DV04', 'CH010'),
    ('HD034', 'Phí quản lý', '2024-02-15 00:00:00', 0, 1, NULL, 'DV07', 'CH009'),
    ('HD035', 'Hóa đơn điện nước', '2024-01-20 00:00:00', 1000000, 1, NULL, 'DV06', 'CH007');
 
-- Dữ liệu cho bảng PhuTrach
INSERT INTO PhuTrach (MaHD, MaNV) VALUES
    ('HD001', 'NV0011'),
    ('HD002', 'NV0002'),
    ('HD003', 'NV0003'),
    ('HD003', 'NV0007'),
    ('HD004', 'NV0005'),
    ('HD005', 'NV0012'),
    ('HD006', 'NV0006'),
    ('HD007', 'NV0027'),
    ('HD008', 'NV0010'),
    ('HD009', 'NV0028'),
    ('HD010', 'NV0032'),
    ('HD011', 'NV0029'),
    ('HD012', 'NV0026'),
    ('HD013', 'NV0020'),
    ('HD013', 'NV0003'),
    ('HD014', 'NV0016'),
    ('HD015', 'NV0023'),
    ('HD016', 'NV0018'),
    ('HD017', 'NV0020'),
    ('HD018', 'NV0016'),
    ('HD019', 'NV0001'),
    ('HD020', 'NV0004'),
    ('HD021', 'NV0018'),
    ('HD022', 'NV0007'),
    ('HD023', 'NV0032'),
    ('HD024', 'NV0005'),
    ('HD025', 'NV0023'),
    ('HD026', 'NV0010'),
    ('HD027', 'NV0028'),
    ('HD028', 'NV0032'),
    ('HD029', 'NV0022'),
    ('HD030', 'NV0023'),
    ('HD031', 'NV0006'),
    ('HD032', 'NV0003'),
    ('HD033', 'NV0022'),
    ('HD034', 'NV0011'),
    ('HD035', 'NV0018');
    
-- Dữ liệu cho bảng ThietBi
INSERT INTO ThietBi (MaTBi, TenTBi, SL) VALUES
    ('TBi001', 'Thang máy', 20),
    ('TBi002', 'Thiết bị phòng cháy chữa cháy', 36),
    ('TBi003', 'Đèn chiếu sáng', 100),
    ('TBi004', 'Camera an ninh', 40);
    
INSERT INTO BoTri (MaTBi, MaTang, SL) VALUES
    ('TBi001', 'A01', 5),
    ('TBi002', 'A02', 6),
    ('TBi003', 'A03', 20),
    ('TBi004', 'A01', 8),
    ('TBi001', 'B01', 5),
    ('TBi002', 'B01', 8),
    ('TBi003', 'B02', 30),
    ('TBi004', 'B03', 10),
    ('TBi001', 'C01', 5),
    ('TBi001', 'C02', 5),
    ('TBi002', 'C02', 10),
    ('TBi003', 'C05', 25),
    ('TBi004', 'C06', 12);

INSERT INTO ThongBao (MaTB, LoaiTB, TieuDe, NoiDung, NgTB) VALUES
    ('TB001', 'Sự kiện', 'Hội nghị chung cư', 'Kính mời các cư dân tham gia hội nghị chung cư vào ngày 20/06/2024.', '2024-06-10 08:30:00'),
    ('TB002', 'Quản lý dự án', 'Thông báo tiến độ', 'Cập nhật tiến độ dự án xây dựng hệ thống cấp nước.', '2024-06-12 11:45:00'),
    ('TB003', 'An ninh và an toàn', 'Cảnh báo tội phạm', 'Cảnh báo về việc tăng cường an ninh do có tình trạng trộm cắp diễn ra gần đây.', '2024-06-14 14:20:00'),
    ('TB004', 'Kỹ thuật', 'Bảo trì hệ thống điện', 'Thông báo về việc bảo trì hệ thống điện vào ngày mai.', '2024-06-16 16:10:00'),
    ('TB005', 'Cộng đồng', 'Cuộc họp cư dân', 'Nhắc nhở về cuộc họp cư dân vào ngày 25/06/2024.', '2024-06-18 09:00:00'),
    ('TB006', 'Tài chính', 'Thông báo về hóa đơn', 'Nhắc nhở các cư dân về việc thanh toán hóa đơn trước ngày 30/06/2024.', '2024-06-20 10:30:00'),
    ('TB007', 'Khẩn cấp', 'Cúp nước', 'Thông báo về việc cúp nước tạm thời do công việc bảo trì hệ thống nước.', '2024-06-22 14:15:00'),
    ('TB008', 'Tiện ích và dịch vụ', 'Lịch trình thu gom rác', 'Nhắc nhở về lịch trình thu gom rác hàng tuần.', '2024-06-24 11:20:00'),
    ('TB009', 'Chính sách và quy định', 'Thay đổi chính sách gửi xe', 'Thông báo về thay đổi mới trong chính sách gửi xe.', '2024-06-26 09:45:00');

INSERT INTO TB_CD (MaTB, MaCD) VALUES
    ('TB001', 'CD0001'),
    ('TB002', 'CD0002'),
    ('TB003', 'CD0003'),
    ('TB004', 'CD0004'),
    ('TB005', 'CD0005'),
    ('TB006', 'CD0006'),
    ('TB007', 'CD0007'),
    ('TB008', 'CD0008'),
    ('TB009', 'CD0009');

INSERT INTO PhanAnh (MaPA, LoaiPA, TieuDe, NoiDung, NgPA, TinhTrang, MaCD) VALUES
    ('PA001', 'An ninh trật tự', 'Người lạ mặt', 'Sân tòa B có thanh niên ăn mặt khác lạ và có biểu hiện bất thường', '2024-02-10 08:30:00', 3, 'CD0001'),
    ('PA002', 'Xe cộ', 'Sắp xếp xe tại bãi giữ', 'Xe cộ tại bãi giữ xe sắp xếp không hợp lý, gây cản trở', '2024-02-11 11:45:00', 2, 'CD0001'),
    ('PA003', 'An ninh trật tự', 'Cần kiểm tra an ninh', 'Cần kiểm tra lại hệ thống camera.', '2024-02-12 14:20:00', 3, 'CD0001'),
    ('PA004', 'Bảo trì', 'Hỏng cửa thang máy', 'Cửa thang máy tầng 3 bị hỏng.', '2024-04-12 16:10:00', 1, 'CD0001'),
    ('PA005', 'Khác', 'Thái độ nhân viên', 'Bảo vệ tòa A ca sáng có thái độ khó chịu với cư dân', '2024-03-13 09:00:00', 3, 'CD0006'),
    ('PA006', 'Vệ sinh', 'Cần dọn dẹp khuôn viên', 'Khuôn viên trước toà nhà cần được dọn dẹp.', '2024-04-14 10:30:00', 1, 'CD0030'),
    ('PA007', 'Xe cộ', 'Xe máy gây cản trở', 'Xe máy gây cản trở cho lối đi.', '2024-05-15 14:15:00', 2, 'CD0009'),
    ('PA008', 'Bảo trì', 'Hệ thống chiếu sáng yếu', 'Đèn hành lang tại tầng A02 chiếu sáng yếu', '2024-01-16 11:20:00', 3, 'CD0010'),
    ('PA009', 'Vệ sinh', 'Bãi rác đầy', 'Bãi rác đầy không có người đến thu gom', '2024-01-17 09:45:00', 1, 'CD0005'),
    ('PA010', 'Quản lý', 'Giao dịch hóa đơn', 'Gặp vấn đề với việc giao dịch hóa đơn.', '2024-05-18 13:00:00', 1, 'CD0027'),
	('PA011', 'An ninh trật tự', 'Tiếng ồn lạ', 'Có tiếng ồn lạ phát ra từ tầng 2 của tòa A.', '2024-02-09 09:30:00', 2, 'CD0030'),
    ('PA012', 'Xe cộ', 'Xe hơi đậu trái phép', 'Xe hơi đậu trái phép ở vị trí cấm đỗ, gây cản trở giao thông.', '2024-04-20 10:15:00', 2, 'CD0029'),
    ('PA013', 'Vệ sinh', 'Khu vực nhà rác bẩn', 'Rác từ thùng bị tràn ra ngoài', '2024-05-21 11:20:00', 1, 'CD0009'),
    ('PA014', 'Bảo trì', 'Thiết bị phòng cháy chữa cháy hỏng', 'Một số thiết bị PCCC không hoạt động, cần kiểm tra và sửa chữa.', '2024-05-22 13:45:00', 1, 'CD0015'),
    ('PA015', 'Khác', 'Mất điện toàn khu vực', 'Khu vực A đang mất điện, cần kiểm tra và khắc phục ngay.', '2024-03-23 14:30:00', 2, 'CD0017'),
    ('PA016', 'An ninh trật tự', 'Người lạ nghi ngờ', 'Một người lạ nghi ngờ đang lòi đầu ra khỏi cửa sổ tầng 5.', '2024-04-24 15:10:00', 2, 'CD0022'),
    ('PA017', 'Khác', 'Nhân viên giải quyết vấn đề chưa triệt để', 'Tôi có giải quyết một số vấn đề khúc mắc với nhân viên A, nhưng chưa được giải quyết một các triệt để.', '2024-05-25 16:20:00', 1, 'CD0011'),
    ('PA018', 'Vệ sinh', 'Mùi hôi từ bể phốt', 'Mùi hôi từ bể phốt lan ra xung quanh, cần khắc phục.', '2024-05-06 17:00:00', 1, 'CD0002'),
    ('PA019', 'Quản lý', 'Tiền điện nước tăng', 'Tháng này hóa đơn điện nước hộ chúng tôi tăng gấp đôi trong khi lưu lượng sử dụng vẫn vậy. Cần được làm rõ', '2024-01-27 18:15:00', 3, 'CD0004'),
    ('PA020', 'An ninh trật tự', 'Kẻ gian đột nhập', 'Phát hiện kẻ gian đang cố đột nhập vào khu vực hầm để xe.', '2024-03-28 19:30:00', 2, 'CD0009');
    
    CREATE TABLE users(
		id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL
	);