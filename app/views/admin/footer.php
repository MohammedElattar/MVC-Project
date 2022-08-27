</div>
</div>
</section>
<! --/wrapper -->
    </section>
    <!-- /MAIN CONTENT -->

    <!--main content end-->

    <!--footer start-->
    <footer class="site-footer">
        <div class="text-center">
            2014 - Alvarez.is
            <a href="index#" class="go-top">
                <i class="fa fa-angle-up"></i>
            </a>
        </div>
    </footer>
    <!--footer end-->
    </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="<?= ASSETS_ADMIN ?>js/showTables.js"></script>
    <script src="<?= ASSETS_ADMIN ?>js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="<?= ASSETS_ADMIN ?>js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?= ASSETS_ADMIN ?>js/jquery.scrollTo.min.js"></script>
    <script src="<?= ASSETS_ADMIN ?>js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="<?= ASSETS_ADMIN ?>js/common-scripts.js"></script>

    <script type="text/javascript" src="<?= ASSETS_ADMIN ?>js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="<?= ASSETS_ADMIN ?>js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="<?= ASSETS_ADMIN ?>js/sparkline-chart.js"></script>
    <script src="<?= ASSETS_ADMIN ?>js/zabuto_calendar.js"></script>
    <script src="<?= ASSETS_ADMIN ?>js/admin_ajax.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var unique_id = $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Welcome to Shopping Page!',
                // (string | mandatory) the text inside the notification
                text: 'This area controlls everything in your website',
                // (string | optional) the image to display on the left
                image: '<?= ASSETS_ADMIN ?>img/ui-sam.jpg',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: 3000,
                // (string | optional) the class name you want to apply to that specific message
                class_name: 'my-sticky-class'
            });

            return false;
        });
    </script>

    <script type="application/javascript">
        $(document).ready(function() {
            $("#date-popover").popover({
                html: true,
                trigger: "manual"
            });
            $("#date-popover").hide();
            $("#date-popover").click(function(e) {
                $(this).hide();
            });

            $("#my-calendar").zabuto_calendar({
                action: function() {
                    return myDateFunction(this.id, false);
                },
                action_nav: function() {
                    return myNavFunction(this.id);
                },
                ajax: {
                    url: "show_data.php?action=1",
                    modal: true
                },
                legend: [{
                        type: "text",
                        label: "Special event",
                        badge: "00"
                    },
                    {
                        type: "block",
                        label: "Regular event",
                    }
                ]
            });
        });


        function myNavFunction(id) {
            $("#date-popover").hide();
            var nav = $("#" + id).data("navigation");
            var to = $("#" + id).data("to");
            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }
    </script>


    </body>

    </html>

<script>
    var nice = 
    $(this.refs.container).niceScroll({
        cursorcolor: '#f16221',
        cursorwidth: '14',
        cursorminheight: '64', 
        scrollspeed: '50',
        autohidemode: 'false',
        overflowy: 'false'
    });

var _super = nice.getContentSize;

nice.getContentSize = function () {
    var page = _super.call(nice);
    page.h = nice.win.height();
    return page;
}

$('.nicescroll-rails.nicescroll-rails-vr').remove();
</script>