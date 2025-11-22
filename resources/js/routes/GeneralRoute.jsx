
import NotFound from "@/pages/404";
import Profile from "@/pages/auth/Profile";
import BlogDetail from "@/pages/BlogDetail";
import BlogPages from "@/pages/BlogPages";
import Checkout from "@/pages/Checkout";
import Collections from "@/pages/Collections";
import Homepage from "@/pages/Homepage";
import Introduce from "@/pages/Introduce";
import OrderPayment from "@/pages/OrderPayment";
import ProductDetail from "@/pages/Products/ProductDetail";
import ProductsLists from "@/pages/Products/ProductsLists";
import SearchOrder from "@/pages/SearchOrder";
import ChinhSachBaoMat from "@/pages/support/ChinhSachBaoMat";
import ChinhSachDoiTra from "@/pages/support/ChinhSachDoiTra";
import ChinhSachKhieuNai from "@/pages/support/ChinhSachKhieuNai";
import ChinhSachVanChuyen from "@/pages/support/ChinhSachVanChuyen";
import DieuKhoanChung from "@/pages/support/DieuKhoanChung";
import HuongDanMuaHang from "@/pages/support/HuongDanMuaHang";
import HuongDanThanhToan from "@/pages/support/HuongDanThanhToan";
import QuyenKiemSoatThongTin from "@/pages/support/QuyenKiemSoatThongTin";
import GeneralPath from "@/routes/GeneralPath";
const GeneralRoute = [
    { path: GeneralPath.HOMEPAGE, element: <Homepage /> },
    { path: GeneralPath.PRODUCTS, element: <ProductsLists /> },
    { path: GeneralPath.PRODUCT_DETAIL, element: <ProductDetail /> },
    { path: GeneralPath.COLLECTIONS, element: <Collections /> },
    { path: GeneralPath.BLOGS, element: <BlogPages /> },
    { path: GeneralPath.ABOUT, element: <Introduce /> },
    { path: GeneralPath.PROFILE, element: <Profile /> },
    { path: GeneralPath.CHECKOUT, element: <Checkout /> },
    { path: GeneralPath.ORDER_PAYMENT, element: <OrderPayment /> },
    { path: GeneralPath.BLOG_DETAIL, element: <BlogDetail /> },
    { path: GeneralPath.SEARCH_ORDER, element: <SearchOrder /> },

    { path: GeneralPath.DIEUKHOANCHUNG, element: <DieuKhoanChung /> },
    { path: GeneralPath.MUAHANG, element: <HuongDanMuaHang /> },
    { path: GeneralPath.THANHTOAN, element: <HuongDanThanhToan /> },
    { path: GeneralPath.BAOMAT, element: <ChinhSachBaoMat /> },
    { path: GeneralPath.DOITRA, element: <ChinhSachDoiTra /> },
    { path: GeneralPath.KHIEUNAI, element: <ChinhSachKhieuNai /> },
    { path: GeneralPath.VANCHUYEN, element: <ChinhSachVanChuyen /> },
    { path: GeneralPath.QUYENKIEMSOATTHONGTIN, element: <QuyenKiemSoatThongTin /> },

    { path: '*', element: <NotFound /> }
]
export default GeneralRoute;
