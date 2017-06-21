<?php 
$configs = array(
    'name' => 'spidername',

    'log_show' => false,//显示爬取面板
    'log_file' => 'path',
    'log_type' => 'error',//info,warn,debug,error

    'input_encoding' => 'GB2312',
    'output_encoding' => 'GB2312',

    'tasknum' => 5,

    'multiserver' => true,
    'serverid' => 2,

    'save_running_state' => true,

    'proxy' => 'http://host:port',// 验证代理http://user:pass@host:port'

    'interval' => 1000,//爬取间隔毫秒
    'timeout' => 5,     //超时时间秒
    'max_try' => 5 ,// 重复爬取5次
    'max_depth' => 5, //爬虫爬取网页深度
    'max_fields' => 100, //爬虫爬取内容网页最大条数,默认值为0，即不限制

    'user_agent' => phpspider::AGENT_ANDROID, //AGENT_IOS AGENT_PC AGENT_MOBILE "Mozilla/5.0"
    'user_agents' => array(
                            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36",
                            "Mozilla/5.0 (iPhone; CPU iPhone OS 9_3_3 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13G34 Safari/601.1",
                            "Mozilla/5.0 (Linux; U; Android 6.0.1;zh_cn; Le X820 Build/FEXCNFN5801507014S) AppleWebKit/537.36 (KHTML, like Gecko)Version/4.0 Chrome/49.0.0.0 Mobile Safari/537.36 EUI Browser/5.8.015S",
                    ),
    'client_ip' => '192.168.0.2', //爬虫爬取网页所使用的伪IP，用于破解防采集
    'client_ips' => array(
                        '192.168.0.2', 
                        '192.168.0.3',
                        '192.168.0.4',
                    ),
    'export' => array(
                    'type' => 'csv', 
                    'file' => PATH_DATA.'/qiushibaike.csv', // data目录下
                    ),
                // 'export' => array(
                //     'type'  => 'sql',
                //     'file'  => PATH_DATA.'/qiushibaike.sql',
                //     'table' => '数据表',
                // )
                // 'export' => array(
                //     'type' => 'db',
                //     'table' => '数据表',  // 如果数据表没有数据新增请检查表结构和字段名是否匹配
                // )
    'domains' => array(
                        'qiushibaike.com',
                        'www.qiushibaike.com'
                        ),//定义爬虫爬取哪些域名下的网页, 非域名下的url会被忽略以提高爬取速度
    'scan_urls' => array(
                        'http://www.qiushibaike.com/'
                        ), //定义爬虫的入口链接, 爬虫从这些链接开始爬取,同时这些链接也是监控爬虫所要监控的链接
    'content_url_regexes' => array(
                                        "http://www.qiushibaike.com/article/\d+",
                                    ), //定义内容页url的规则
    'list_url_regexes' => array(
                                    "http://www.qiushibaike.com/8hr/page/\d+\?s=\d+"
                                ), //定义列表页url的规则

    'fields' => array(
        array(
            'name' => "content", //给此项数据起个变量名
            'selector_type' => 'regex', //抽取规则的类型
            'selector' => "//*[@id='single-next-link']", //定义抽取规则
            'required' => true, //定义该field的值是否必须,赋值为true的话, 如果该field没有抽取到内容, 该field对应的整条数据都将被丢弃
            'repeated' => true, //定义该field抽取到的内容是否是有多项, 默认false 赋值为true的话, 无论该field是否真的是有多项, 
                                // 抽取到的结果都是数组结构
            'children' => array(
                   array(
                       'name' => "replay",
                       'selector' => "//div[contains(@class,'replay')]",
                       'repeated' => true,
                   ),
                   array(
                       'name' => "report",
                       'selector' => "//div[contains(@class,'report')]",
                       'repeated' => true,
                   )
               ),
        ),
        array(
            'name' => "comment_id",
            'selector' => "//div/@data-aid",
        ),
        array(
            'name' => "comments",
            'source_type' => 'attached_url',    //选择attached_url可以发起一个新的请求, 然后从请求返回的数据中抽取
                                                // 选择url_context可以从当前网页的url附加数据（点此查看“url附加数据”实例解析）中抽取
            // "comments"是从发送"attached_url"这个异步请求返回的数据中抽取的
            // "attachedUrl"支持引用上下文中的抓取到的"field", 这里就引用了上面抓取的"comment_id"
            'attached_url' => "https://www.zhihu.com/r/answers/{comment_id}/comments", //当source_type设置为attached_url时, 定义新请求的url
            'selector_type' => 'jsonpath'
            'selector' => "$.data",
            'repeated => true,
            'children' => array(
                ...
            )
        }
    )
);