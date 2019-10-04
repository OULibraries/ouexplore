
    <?php include str_replace('/tpl','',__DIR__) . '/functions.php'; ?>
    <section id="contact">
        <div class="container">
            <div>
                <h2>Issues</h2>
                <p>
                    <strong>OU University Libraries</strong><br>
                    401 W. Brooks St. Norman, OK 73019<br>
                    (405) 325-4142
                </p>
            </div>
            <div>
                <?php getIssues(); ?>
            </div>
        </div>
    </section>