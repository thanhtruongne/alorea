import { Typography } from 'antd';

const { Title, Paragraph, Text } = Typography;
const ChinhSachDoiTra = () => (
  <div className="min-h-screen bg-gray-50">
    <div className="bg-gradient-to-br from-burgundy-primary to-burgundy-dark">
      <div className="relative overflow-hidden">
        <div className="absolute inset-0 bg-black/20"></div>
        <div className="relative px-4 py-10 sm:py-14 lg:py-20 mt-10">
          <div className="max-w-4xl mx-auto text-center">
            <Title level={1} className="!text-white !text-2xl sm:!text-4xl lg:!text-5xl !font-serif !mb-4">
              CHÍNH SÁCH ĐỔI TRẢ
            </Title>
            <div className="w-16 sm:w-24 h-1 bg-white mx-auto mb-4 sm:mb-6"></div>
          </div>
        </div>
      </div>
    </div>
    <div className="px-4 sm:px-6 lg:px-8 py-8">
      <div className="max-w-3xl mx-auto bg-white rounded-xl shadow-md p-4 sm:p-8 text-base sm:text-lg">
        <Paragraph>
         “Sự tin cậy của quý khách là ưu tiên hàng đầu của chúng tôi. Với chính sách đổi trả bảo hành linh hoạt kết hợp cùng tổng đài hỗ trợ 0911.468.678, chúng tôi sẵn sàng giải quyết mọi vấn đề của bạn.”
        </Paragraph>
      </div>
    </div>
  </div>
);
export default ChinhSachDoiTra;
