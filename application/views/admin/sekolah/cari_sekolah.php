<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Cari Sekolah</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="<?= base_url('admin/tambah_sekolah'); ?>" class="btn btn-sm btn-neutral">Tambah</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <!-- Flashdata! -->
            <?php if ($this->session->flashdata('flash')) : ?>
                <div class="col">
                    <div class="row mt-2">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">Data sekolah
                            <strong>berhasil</strong> <?= $this->session->flashdata('flash'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="mb-0">Cari Sekolah</h3>
                        </div>
                        <div class="col-6">Menampilkan <?php echo $all_sekolah; ?> hasil pencarian dengan kata kunci "<b><?php echo $keyword; ?></b>"</div>
                    </div>
                </div>

                <?php if (empty($sekolah)) : ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="alert alert-primary">
                                    Belum ada data sekolah yang ditambahkan. Silahkan menambahkan baru.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <a href="<?= base_url('admin/tambah_sekolah'); ?>"><i class="fa fa-plus"></i> Tambah sekolah</a>
                                <br>
                                <a href="<?= base_url('admin/sekolah'); ?>"><i class="fa fa-list"></i> Kelola Sekolah</a>
                            </div>
                        </div>

                    </div>
                <?php else : ?>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($sekolah as $row) : ?>
                                <div class="col-md-3">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h4 class="card-heading text-center"><?= strtoupper($row['nama_sekolah']) ?></h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img alt="<?= $row['nama_sekolah'] ?>" class="img img-fluid rounded" src="
                                            <?php if ($row['gambar'] == 'default.png'|| $row['gambar'] == null) : ?>
                                                <?php echo base_url('assets/img/sekolah/default.png'); ?>
                                            <?php else : ?>
                                                <?php echo base_url('assets/img/sekolah/gambar/' . $row['gambar']); ?>
                                            <?php endif; ?>
                                            " style="width: 1000px; max-height: 800px">
                                            </div>
                                            <h5 class="card-heading text-center mt-3"><?= strtoupper($row['kota']); ?></h5>
                                        </div>
                                        <div class="card-footer text-center">
                                            <!-- <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-<?= $row['id'] ?>"><i class="fa fa-eye"></i></a> -->
                                            <a href="<?= base_url('admin/detail_sekolah/' . $row['id']); ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                            <a href="<?= base_url('admin/edit_sekolah/' . $row['id']); ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                        </div>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?= $this->pagination->create_links(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>