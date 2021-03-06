<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
namespace fecshop\models\mongodb\product;
use Yii;
use yii\mongodb\ActiveRecord;
/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Review extends ActiveRecord
{
    public static $_customAttrs;
	# 评论默认状态，也就是用户添加了评论后的状态（前面是客户的评论信息需要审核的前提下，如果客户信息不需要审核的话，则就是ACTIVE_STATUS）
	const NOACTIVE_STATUS 	= 10;
	# 审核通过的状态
	const ACTIVE_STATUS 	= 1;
	# 审核拒绝的状态
	const REFUSE_STATUS 	= 2;
	
	public static function collectionName()
    {
	   return 'review';
    }
	# 动态增加字段。
	public static function addCustomAttrs($attrs){
		self::$_customAttrs = $attrs;
	}
	
    public function attributes($origin=false)
    {
		$origin = [
			'_id', 
			'product_spu',
			'product_sku',
			'product_id',
			'rate_star',
		    'name',
			'user_id',
			'ip',
	        'summary', 
	        'review_content', 		# 评论的内容
			'review_date',			# 评论的最后更新时间
			'store',			# store
			'lang_code',		# 语言
			'status',			# 审核状态 10代表未审核，1代表已审核。
			'audit_user',		# 审核账号
			'audit_date',		# 审核时间
		];
		if($origin){ # 取原始的数据
			return $origin;
		}
	    if(is_array(self::$_customAttrs) && !empty(self::$_customAttrs)){
			$origin = array_merge($origin,self::$_customAttrs);
		}
		return $origin;
    }
	
	
	
	public static function create_index(){
		$indexs = [
			['product_spu' 		=> -1],
			['product_sku' 		=> -1],
			['product_id' => -1],
			['user_id' => -1],
			
		];
      
		$options = ['background' => true, 'socketTimeoutMS' => 300000];
		foreach($indexs as $columns){
			self::getCollection()->createIndex($columns,$options);
		}
	}
	
	
	
	
	
}