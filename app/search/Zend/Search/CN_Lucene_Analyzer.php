<?
//require_once 'Zend/Search/Lucene/Analysis/Analyzer.php';
require_once 'Zend/Search/Lucene/Analysis/Analyzer/Common.php';
class CN_Lucene_Analyzer extends Zend_Search_Lucene_Analysis_Analyzer_Common {

		//private $_position;

		private $_cnStopWords = array();

		public function setCnStopWords($cnStopWords){
				$this->_cnStopWords = $cnStopWords;
		}


		/**
		 * Reset token stream 
		 */ 
		public function reset(){
				$this->_position = 0;
				$search = array(",", "/", "\\", ".", ";", ":", "\"", "!", "~", "`", "^", "(", ")", "?", "-", "'", "<", ">", "$", "&", "%", "#", "@", "+", "=", "{", "}", "[", "]", "：", "）", "（", "．", "。", "，", "！", "；", "“", "”", "‘", "’", "［", "］", "、", "—", "　", "《", "》", "－", "…", "【", "】","的");
				$this->_input = str_replace($search,' ',$this->_input);
				$this->_input = str_replace($this->_cnStopWords,' ',$this->_input);
				mb_internal_encoding(mb_detect_encoding($this->_input)); 
		}

		/**
		 * Tokenization stream API 
		 * Get next token 
		 * Returns null at the end of stream 
		 * 
		 * @return Zend_Search_Lucene_Analysis_Token|null 
		 */ 
		public function nextToken(){
				if ($this->_input === null) {
						return null;
				}
				$len = mb_strlen($this->_input);
				while ($this->_position < $len) {
						$termStartPosition = $this->_position;
						$length=1;
						$current_char = mb_substr($this->_input,$this->_position,1);
						$next_char = mb_substr($this->_input,$this->_position+1,1);
						if(ord($current_char)>127){
								$i=0;
								while ($this->_position < $len && ord( $next_char)>127) {
										$this->_position++;
										$next_char = mb_substr($this->_input,$this->_position+1,1);
										$length=2;
										if($i++==1){
												$this->_position--;
												$this->_position--;
												break;
										}
								}
						}else{
								while ($this->_position < $len && ctype_alnum( $next_char)) {
										$this->_position++;
										$length++;
										$next_char = mb_substr($this->_input,$this->_position+1,1);
								}
						}
						$this->_position++;

						$str = trim(mb_substr($this->_input,$termStartPosition,$length));
						$token = new Zend_Search_Lucene_Analysis_Token(
								$str,
								0,
								strlen($str)
						);
						$token = $this->normalize($token);
						if ($token !== null) {
								return $token;
						}
				}
				return null;
		}
}
?>
