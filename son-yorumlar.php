<?php
class SonYorumlar extends WP_Widget {
    function __construct() {
        parent::__construct(
            'son-yorumlar',  // Base ID
            'Evil: Son Yorumlar'   // Name
        );
        add_action( 'widgets_init', function() {
            register_widget( 'SonYorumlar' );
        });
    }
    
    public $args = array(
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>'
    );
 
    public function widget( $args, $instance ) {
 
        echo $args['before_widget'];
 
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
        
        if($instance["kactanegosterilsin"] != null){
            $comments = get_comments(array('number'=>$instance["kactanegosterilsin"],'status'=>'approve','post_status'=>'publish'));
        }else{
            $comments = get_comments(array('number'=>5,'status'=>'approve','post_status'=>'publish'));
        }
        ?>

        <ul class="son-yorumlar">
            <?php foreach ($comments as $comment): ?>
                <li>
                    <div class="tab-item-inner clean">
                        <?php $str=explode(' ',get_comment_excerpt($comment->comment_ID)); $comment_excerpt=implode(' ',array_slice($str,0,11)); if(count($str) > 11 && substr($comment_excerpt,-1)!='.') $comment_excerpt.='...' ?>
                        
                        <span class="yorumu-yapan"><?php echo esc_attr( $comment->comment_author ); ?></span>
                        
                        <span class="yorumu"><a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>"><?php echo esc_attr( $comment_excerpt ); ?></a></span>
                    </div>
				</li>
				<?php endforeach; ?>
			</ul>
		<?php 
        
        echo $args['after_widget'];
    }
 
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
        $kactanegosterilsin = ! empty( $instance['kactanegosterilsin'] ) ? $instance['kactanegosterilsin'] : esc_html__( '', 'text_domain' );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Başlık:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'Text' ) ); ?>"><?php echo esc_html__( 'Kaç Tane Gösterilsin: (standart 5)', 'text_domain' ); ?></label>
            <input type="number" min="1" max="5" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'kactanegosterilsin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'kactanegosterilsin' ) ); ?>" cols="30" rows="10"><?php echo esc_attr( $kactanegosterilsin ); ?>
        </p>
        <?php
    }
 
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['kactanegosterilsin'] = ( !empty( $new_instance['kactanegosterilsin'] ) ) ? $new_instance['kactanegosterilsin'] : '';
        return $instance;
    }
}
$sonyorumlar = new SonYorumlar();
?>