<?php


class Kuaidi100
{
    /**
     * API根路径
     * @var string
     */
    protected $ApiBase = 'https://m.kuaidi100.com/query';
    private $config;
    public function __construct()
    {
    }
    /**
     * 查询快递状态
     * @param array sn   快递订单号
     *              code 快递公司编码
     *              type 获取快递信息 0 json 1 url 2 html(url li))
     * @return array | boolean
     */
    public function search($data)
    {
        $type = intval($data['type']);
        if ($type == 1) { //url模式
            $url = $this->query_url($data['code'], $data['sn'], $data['temp']);
            if ($url) {
                $return = array();
                $return['status'] = 1;
                $return['info'] = $url;
                return $return;
            } else $type = 2;
        }
        $params = array(
            'postid' => $data['sn'],
            'id' => 1,
            'valicode' => '',
            'temp' => $this->random(),
            'type' => $data['code'],
            'phone' => '',
            'token' => '',
            'platform' => 'MWWW',
            'coname' => 'indexall',
        );
        $header = array(
            'User-Agent: application/json, text/javascript, */*; q=0.01',
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
        );
        $ref_url = 'https://m.kuaidi100.com/app/query/?coname=indexall&nu=' . $data['sn'] . '&com=' . $data['code'];
        $cookie = $this->getcookie($ref_url, $header);
        $opt = array(CURLOPT_REFERER => $ref_url, CURLOPT_COOKIE => $cookie);
        $data = curlget($this->ApiBase, $params, 'POST', $header, false, false, $opt);
        $result = json_decode($data, true);
        if ($type == 2) { //html模式
            if (empty($data['class'])) $data['class'] = 'express_list';
            $html = '<ul class="' . $data['class'] . '">';
            if ($result['data']) {
                foreach ($result['data'] as $v) {
                    $html .= '<li><span>' . $v['time'] . '</span>' . $v['context'] . '</li>';
                }
            } else {
                $html .= '<li>' . ($result['message'] ? $result['message'] : '查询失败') . '</li>';
            }
            $html .= '<li>查询数据由：快递100 网站提供</li>';
            $html .= '</ul>';
            $return = array();
            $return['status'] = 1;
            $return['info'] = $html;
            return $return;
        } else { //json 模式
            $return = array();
            if ($result['status'] == '200') {
                $return = $result; //state 0：在途1：揽件2：疑难3：签收4：退签5：派件6：退回
                $return['status'] = 1;
            } else {
                $return['status'] = 0;
                $return['info'] = $result['message'] ? $result['message'] : '查询失败';
            }
            return $return;
        }
    }
    /**
     * 获取直接查询快递URL
     * @param string $code 快递订单号
     * @param string $sn 快递公司编码
     * $param string $temp 备用参数 手机页面点击"返回"跳转的地址
     * @return string
     */
    private function query_url($code, $sn, $temp = '')
    {
        if (empty($code) || empty($sn)) return false;
        if (is_mobile()) {
            $url = "https://m.kuaidi100.com/index_all.html?type=" . $code . "&postid=" . $sn;
            if ($temp) $url .= "&callbackurl=" . $temp;
        } else {
            $url = "https://www.kuaidi100.com/chaxun?com=" . $code . "&nu=" . $sn;
        }
        return $url;
    }
    private function getcookie($url, $header = array())
    {
        $cookie = filecache('kuaidi100');
        if ($cookie) return $cookie;
        $opt = array(CURLOPT_HEADER => true);
        $result = curlget($url, '', 'GET', $header, false, false, $opt);
        preg_match_all('/.*?\r\nSet-Cookie: (.*?);.*?/si', $result, $matches);
        if (isset($matches[1])) {
            $cookie = implode('; ', $matches[1]);
        }
        if ($cookie) filecache('kuaidi100', $cookie);
        return $cookie;
    }
    private function random($min = 0, $max = 1)
    {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
    /**
     *获取快递公司编号
     */
    public function com_url()
    {
        return "https://www.kuaidi100.com/download/api_kuaidi100_com(20140729).doc";
    }
}
