<?php 
    namespace App\Controller;

    use App\Entity\Article;

    use Doctrine\Persistence\ManagerRegistry;
    
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;

    class ArticleController extends AbstractController{
        private $em;

        public function __construct(ManagerRegistry $registry)
        {
            $this->em = $registry;
        }
        /**
         * @Route("/", name="article_list")
         * @Method({"GET"})
         * */
        public function index(){

            $articles = $this->em->getRepository(Article::class)->findAll();

            return $this->render('articles/index.html.twig', array('articles' => $articles ));  
        }
        
        
        /**
         * @Route("/article/new", name="new_article")
         * @Method({"GET", "POST"})
         * */
        
        public function new(Request $request){
            $article = new Article();
            
            $form = $this->createFormBuilder($article)
                ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
                ->add('body', TextareaType::class, array(
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('save', SubmitType::class, array(
                    'label' => 'Create',
                    'attr' => array('class' => 'btn btn-primary mt-3')
                ))
                ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $article = $form->getData();

                $entityManager = $this->em->getManager();
                $entityManager->persist($article);
                $entityManager->flush();

                return $this->redirectToRoute('article_list');
            }

            return $this->render('articles/new.html.twig', array(
                'form' => $form->createView() 
            ));    
        }

        /**
         * @Route("/article/edit/{id}", name="edit_article")
         * @Method({"GET", "POST"})
         * */
        
        public function edit(Request $request, $id){
            $article = new Article();
            $article = $this->em->getRepository(Article::class)->find($id);
            
            $form = $this->createFormBuilder($article)
                ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
                ->add('body', TextareaType::class, array(
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('save', SubmitType::class, array(
                    'label' => 'Update',
                    'attr' => array('class' => 'btn btn-success mt-3')
                ))
                ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                // $article = $form->getData();

                $entityManager = $this->em->getManager();
                // $entityManager->persist($article);
                $entityManager->flush();

                return $this->redirectToRoute('article_list');
            }

            return $this->render('articles/edit.html.twig', array(
                'form' => $form->createView() 
            ));    
        }

        
        /**
         * @Route("/article/delete/{id}")
         * @Method({"DELETE"})
         * */
        
        public function delete(Request $request, $id){
            $article = $this->em->getRepository(Article::class)->find($id);
            
            $entityManager = $this->em->getManager();
            $entityManager->remove($article);
            $entityManager->flush(); 
            
            $response = new Response();
            $response->send();
        }
        
        /**
         * @Route("/article/{id}", name="article_show")
         * @Method({"GET"})
         * */
        
        public function show($id){
            $article = $this->em->getRepository(Article::class)->find($id);
            
            return $this->render('articles/show.html.twig', array('article' => $article ));              
        } 


         /**
         *@Route("/article/save") 
        */
        // this returns an error for getDoctrine()!!!!
        // public function save(){
        //     $entityManager = $this->getDoctrine()->getManager();

        //     $article = new Article();
        //     $article->setTitle('Article One');
        //     $article->setBody('This is the body for article one.');

        //     $entityManager->persist($article);

        //     $entityManager->flush();

        //     return new Response('Saved an article with id'.$article->getId());
        // }
    }
    // 2. video 18:43nal Brad

?>